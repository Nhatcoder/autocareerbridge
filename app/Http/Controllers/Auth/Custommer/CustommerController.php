<?php

namespace App\Http\Controllers\Auth\Custommer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustommerRequest;
use Illuminate\Http\Request;
use App\Services\Custommer\CustommerService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class CustommerController
 * @package App\Http\Controllers\Auth\Custommer
 *
 * @author Tran Van Nhat <trannhat7624@gmail.com>
 * @see viewRegister
 * @see register
 * @see viewLogin
 * @since 1.0.0
 */
class CustommerController extends Controller
{
    public $custommerService;
    /**
     * CustommerService constructor.
     * @param CustommerService $custommerService
     */
    public function __construct(CustommerService $custommerService)
    {
        $this->custommerService = $custommerService;
    }

    /**
     * Show the registration form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewRegister()
    {
        return view('client.pages.auth.register');
    }

    /**
     * Handle the registration
     *
     * @param CustommerRequest $request
     */
    public function register(CustommerRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => ROLE_USER,
            'active' => ACTIVE,
            'email_verified_at' => now(),
        ];

        try {
            $this->custommerService->register($data);
            return redirect()->route('viewLogin')->with('status_success', 'Đăng ký tài khoản thành công');
        } catch (Exception $e) {
            Log::error('File' . $e->getFile() . 'Line' . $e->getLine() . 'Message'
                . $e->getMessage());
            return back()->with('error', 'Xảy ra lỗi khi đăng ký tài khoản');
        }
    }

    /**
     * Show the login form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewLogin()
    {
        return view('client.pages.auth.login');
    }

    /**
     * Handle the login
     *
     * @param CustommerRequest $request
     */
    public function login(CustommerRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $response = $this->custommerService->login($data);
        if ($response['success']) {
            return redirect()->route('home')->with('status_success', $response['message']);
        }

        if (!$response['success']) {
            return back()->withInput()->with('error', $response['message']);
        }
    }

    /**
     * Show the login form with google
     *
     */
    public function viewLoginWithGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')
                ->with(['prompt' => 'select_account'])
                ->redirect()
                ->getTargetUrl(),
        ]);
    }

    /**
     * Handle the login with google
     *
     */
    public function loginWithGoogle()
    {
        $response = $this->custommerService->loginWithGoogle();
        if ($response['success']) {
            return "<script>window.opener.location.reload(); window.close();</script>";
        }
    }

    /**
     * Handle the logout
     *
     */
    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect()->route('home');
    }

    /**
     * Show the profile
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile()
    {
        return view('client.pages.auth.profile');
    }

    /**
     * Handle the update profile
     *
     */
    public function updateProfile(CustommerRequest $request)
    {
        $data = [
            'id' => $request->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        try {
            $user = $this->custommerService->updateProfile($data);
            if ($user) {
                return redirect()->route('account.profile')->with('status_success', "Cập nhật thông tin thành công");
            }
        } catch (Exception $e) {
            Log::error('File' . $e->getFile() . 'Line' . $e->getLine() . 'Message'
                . $e->getMessage());
            return back()->with('error', 'Xảy ra lỗi khi cập nhật thông tin');
        }
    }
}
