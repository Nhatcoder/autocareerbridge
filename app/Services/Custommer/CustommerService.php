<?php

namespace App\Services\Custommer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\User\UserRepositoryInterface;

/**
 * Class CustommerService
 * @package App\Services\Custommer
 *
 * @author Tran Van Nhat <trannhat7624@gmail.com>
 * @since 1.0.0
 */
class CustommerService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userReponsitory;

    /**
     * CustommerService constructor.
     * @param UserRepositoryInterface $userReponsitory
     */
    public function __construct(UserRepositoryInterface $userReponsitory)
    {
        $this->userReponsitory = $userReponsitory;
    }

    /**
     * Register a new user
     *
     * @param array $data
     */
    public function register(array $data)
    {
        if (empty($data)) {
            return null;
        }
        $this->userReponsitory->create($data);
    }

    /**
     * Login a user
     *
     * @param array $data
     */
    public function login(array $data)
    {
        if (empty($data)) {
            return ['success' => false, 'message' => 'Dữ liệu không đầy đủ.'];
        }
        $user = $this->userReponsitory->getUserByEmail($data['email']);
        $credentialsByEmail = ['email' => $data['email'], 'password' => $data['password']];

        if (auth()->guard('web')->attempt($credentialsByEmail)) {
            $user = auth()->guard('web')->user();
            if ($user->email_verified_at !== null && $user->active === ACTIVE) {
                return ['success' => true, 'message' => 'Đăng nhập thành công.', 'user' => $user];
            }

            if ($user->email_verified_at !== null && $user->active === INACTIVE) {
                return ['success' => false, 'message' => 'Tài khoản đang bị khóa.'];
            }
        }

        return ['success' => false, 'message' => 'Tài khoản không chính xác.'];
    }

    /**
     * Login a user by google
     */
    public function loginWithGoogle()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = $this->userReponsitory->getUserByEmail($googleUser->email);

        if (!$user) {
            $user = $this->userReponsitory->create([
                'name' => $googleUser->name,
                'avatar_path' => $googleUser->avatar,
                'email' => $googleUser->email,
                'password' => Hash::make(Str::random()),
                'role' => ROLE_USER,
                'active' => ACTIVE,
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
            ]);
        }else{
            $this->userReponsitory->update($user->id, [
                'google_id' => $googleUser->id
            ]);
        }

        auth()->guard('web')->login($user);

        return ['success' => true, 'message' => 'Đăng nhập thành công.', 'user' => $user];
    }
}
