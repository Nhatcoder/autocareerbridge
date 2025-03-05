<?php

namespace App\Services\Managements;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Events\PasswordResetRequested;
use App\Events\EmailConfirmationRequired;
use App\Helpers\LogHelper;
use App\Repositories\Auth\Managements\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Google\Client;
use Google\Service\Calendar;

class AuthService
{
    use LogHelper;
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register($request)
    {
        $data = [
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'remember_token' => Str::random(60),
        ];

        $user =  $this->authRepository->create($data);
        EmailConfirmationRequired::dispatch($user);
    }

    public function confirmMailRegister($token)
    {
        $user = $this->authRepository->userConfirm($token);
        if (!empty($user)) {
            $cachedToken = Cache::get('email_verification_' . $user->id);
            if ($cachedToken === $user->remember_token) {
                Cache::forget('email_verification_' . $user->id);
                $user->email_verified_at = now();
                $user->remember_token = null;
                $user->save();
            };
        }
        return $user;
    }
    public function login($data)
    {
        $user = $this->authRepository->login($data);
        if (empty($user)) {
            return ['success' => false, 'message' => 'Tài khoản không chính xác.'];
        }

        $credentialsByEmail = ['email' => $data['email'], 'password' => $data['password']];
        $credentialsByUsername = ['user_name' => $data['email'], 'password' => $data['password']];

        if (!str_contains($data['email'], '@')) {
            if (preg_match('/[A-Z]/', $data['email'])) {
                return ['success' => false, 'message' => 'Tài khoản không chính xác.'];
            }
        }

        if (auth()->guard('admin')->attempt($credentialsByEmail) || auth()->guard('admin')->attempt($credentialsByUsername)) {
            $user = auth()->guard('admin')->user();

            if ($user->email_verified_at !== null && $user->active === ACTIVE) {
                return ['success' => true, 'message' => 'Đăng nhập thành công.', 'user' => $user];
            }

            auth()->guard('admin')->logout();

            if ($user->email_verified_at !== null && $user->active === INACTIVE) {
                return ['success' => false, 'message' => 'Tài khoản đang bị khóa.'];
            }

            if ($user->email_verified_at === null && $user->active === ACTIVE) {
                $this->authRepository->update($user->id, ['remember_token' => Str::random(60)]);
                EmailConfirmationRequired::dispatch($user);
                return ['success' => false, 'message' => 'Vui lòng xác nhận email trước khi đăng nhập.'];
            }
        }

        return ['success' => false, 'message' => 'Tài khoản không chính xác.'];
    }

    public function checkForgotPassword($email)
    {
        $user = $this->authRepository->checkForgotPassword($email);
        if (empty($user)) {
            return ['success' => false, 'message' => 'Email không tồn tại.'];
        }

        $cacheKey = 'forgot_password_last_sent:' . $email;
        if (Cache::has($cacheKey)) {
            $cacheValue = Cache::get($cacheKey);

            if ($cacheValue && $cacheValue > now()->timestamp) {
                $remainingTime = (int) ceil(($cacheValue - now()->timestamp) / 60);
                $remainingSeconds = (int) ceil(($cacheValue - now()->timestamp));
                if ($remainingSeconds < 60) {
                    return ['success' => false, 'message' => "Vui lòng thử lại sau $remainingSeconds giây."];
                } else {
                    $remainingTime = (int) ceil($remainingSeconds / 60);
                    return ['success' => false, 'message' => "Vui lòng thử lại sau $remainingTime phút."];
                }
            }
        }

        Cache::put($cacheKey, now()->addMinutes(5)->timestamp);

        $token = Str::random(60);
        $user->update(['remember_token' => $token]);

        PasswordResetRequested::dispatch($user);

        return ['success' => true, 'message' => 'Vui lòng kiểm tra email đổi mật khẩu!'];
    }

    public function confirmMailChangePassword($token)
    {
        $user = $this->authRepository->userConfirm($token);
        if (empty($user)) {
            return null;
        }

        return $user;
    }

    public function postPassword($request)
    {
        $user = $this->authRepository->userConfirm($request->remember_token);
        if (!empty($user)) {
            $cachedToken = Cache::get('token_change_password_' . $user->id);
            if ($cachedToken === $user->remember_token) {
                Cache::forget('token_change_password_' . $user->id);
                $data = [
                    'password' => Hash::make($request->password),
                    'remember_token' => NULL,
                ];
                $user->update($data);
            };
        }
        return $user;
    }


    public function logout($id)
    {
        $user = $this->authRepository->find($id);
        if (empty($user)) {
            return null;
        }
        Auth::guard('admin')->logout();
    }

    /**
     * Redirect the user to the Google authentication page.
     * @author TranVanNhat <tranvannhat7624@gmail>
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(config('services.google.scopes'))
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent select_account'
            ])
            ->redirect();
    }

    /**
     * Handle the callback from Google after authorization and save tokens
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     *
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = auth('admin')->user();

            if (!$user || $user->role !== ROLE_COMPANY || $user->email !== $googleUser->email) {
                return null;
            }

            $user->update([
                'access_token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
                'token_expires_at' => now()->addSeconds($googleUser->expiresIn),
            ]);

            return $user;
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return null;
        }
    }

    /**
     * Refresh the Google access token for the authenticated admin user
     *
     * @return string The new or current access token
     * @throws \Exception If refresh token is not found or refresh process fails
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function refreshAccessToken()
    {
        try {
            $user = Auth::guard('admin')->user();

            if (!$user->refresh_token) {
                throw new \Exception('Không tìm thấy refresh token');
            }

            $client = $this->createGoogleClient();

            // Thiết lập token hiện tại
            $accessToken = $this->accessToken($user);
            $client->setAccessToken($accessToken);

            // Kiểm tra và refresh token nếu hết hạn
            if ($client->isAccessTokenExpired()) {
                $newAccessToken = $client->fetchAccessTokenWithRefreshToken($user->refresh_token);

                if (isset($newAccessToken['error'])) {
                    throw new \Exception('Lỗi refresh token: ' . $newAccessToken['error']);
                }

                // Cập nhật token mới vào database
                $user->update([
                    'access_token' => $newAccessToken['access_token'],
                    'token_expires_at' => now()->addSeconds($newAccessToken['expires_in']),
                ]);

                return $newAccessToken['access_token'];
            }

            return $user->access_token;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Check token and set up token
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @throws \Exception
     * @return Client|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getGoogleClient()
    {
        try {
            $user = Auth::guard('admin')->user();

            // Check if user exists and has required role
            if (!$user || $user->role !== ROLE_COMPANY) {
                throw new \Exception('Unauthorized access');
            }

            // If no tokens, redirect to Google login
            if (!$user->access_token || !$user->refresh_token) {
                return $this->redirectToGoogle();
            }

            $client = $this->createGoogleClient();

            // Set up token
            $accessToken = $this->accessToken($user);
            $client->setAccessToken($accessToken);

            // If token expired, try to refresh it
            if ($client->isAccessTokenExpired()) {
                $user->access_token = $this->refreshAccessToken();
                $client->setAccessToken($user->access_token);
            }

            return $client;
        } catch (\Exception $e) {
            return $this->redirectToGoogle();
        }
    }

    public function accessToken($data)
    {
        return [
            'access_token' => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'expires_in' => $data->token_expires_at ? now()->diffInSeconds($data->token_expires_at) : 0,
        ];
    }

    /**
     * Create and configure a new Google Client instance
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @return Client
     */
    private function createGoogleClient()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setAccessType('offline');
        return $client;
    }

    // public function createCalendarEvent($eventData)
    // {
    //     try {
    //         $client = $this->getGoogleClient(); // Lấy client đã được auth sẵn

    //         $service = new Calendar($client); // Tạo service Calendar
    //         $event = new \Google\Service\Calendar\Event([
    //             'summary' => $eventData['summary'], // Tiêu đề sự kiện
    //             'location' => $eventData['location'] ?? '',
    //             'description' => $eventData['description'] ?? '',
    //             'start' => [
    //                 'dateTime' => $eventData['start'], // Thời gian bắt đầu (format ISO8601)
    //                 'timeZone' => config('app.timezone'),
    //             ],
    //             'end' => [
    //                 'dateTime' => $eventData['end'], // Thời gian kết thúc (format ISO8601)
    //                 'timeZone' => config('app.timezone'),
    //             ],
    //             'attendees' => array_map(fn($email) => ['email' => $email], $eventData['attendees'] ?? []),
    //             'reminders' => [
    //                 'useDefault' => false,
    //                 'overrides' => [
    //                     ['method' => 'email', 'minutes' => 24 * 60],
    //                     ['method' => 'popup', 'minutes' => 10],
    //                 ],
    //             ],
    //         ]);

    //         // Gọi API tạo event
    //         $calendarId = 'primary'; // Thường là "primary" cho calendar mặc định
    //         $createdEvent = $service->events->insert($calendarId, $event);

    //         return [
    //             'success' => true,
    //             'event_id' => $createdEvent->getId(),
    //             'html_link' => $createdEvent->getHtmlLink(),
    //         ];
    //     } catch (\Exception $e) {
    //         $this->logExceptionDetails($e);
    //         return [
    //             'success' => false,
    //             'message' => 'Không thể tạo sự kiện trên Google Calendar.',
    //         ];
    //     }
    // }
}
