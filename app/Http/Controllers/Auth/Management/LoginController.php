<?php

namespace App\Http\Controllers\Auth\Management;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Managements\AuthService;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class LoginController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function viewLogin()
    {
        return view('management.auth.login');
    }

    public function checkLogin(LoginRequest $request)
    {
        $data = $request->all();
        $user =  $this->authService->login($data);

        if (empty($user)) {
            return back()->withInput()->with('error', 'Email hoặc tài khoản và mật khẩu không chính xác !');
        }

        if ($user->role === ROLE_ADMIN) {
            dd("Admin");
            // return redirect()->route(route: 'management.home')->with('success', 'Đăng nhập thành công');
        } elseif ($user->role === ROLE_COMPANY) {
            dd("Company");
            // return redirect()->route('management.home')->with('success', 'Đăng nhập thành công');
        } elseif ($user->role === ROLE_UNIVERSITY) {
            dd("University");
            // return redirect()->route('management.home')->with('success', 'Đăng nhập thành công');
        } elseif ($user->role === ROLE_HIRING) {
            dd("Hiring");
            // return redirect()->route('management.home')->with('success', 'Đăng nhập thành công');
        }
    }

    public function viewForgotPassword()
    {
        return view('management.auth.forgotPassword');
    }

    public function checkForgotPassword(Request $request)
    {
        try {
            $this->authService->checkForgotPassword($request);
            return redirect()->route('management.login')->with('status_success', 'Vui lòng kiểm tra email đổi mật khẩu !');
        } catch (\Exception $e) {
            Log::error('Error in checkForgotPassword: ' . $e->getMessage());
            return back()->with('status_fail', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function viewChangePassword(Request $request)
    {
        $user = $this->authService->confirmMailChangePassword($request->token);
        if (empty($user)) {
            return redirect()->route('management.login')->with('status_fail', 'Đổi mật khẩu thất bại !');
        }
        return view('management.auth.changePassword');
    }

    public function postPassword(ForgotPasswordRequest $request)
    {
        try {
            $user = $this->authService->postPassword($request);
            if ($user) {
                return redirect()->route('management.login')->with('status_success', 'Đổi mật khẩu thành công !');
            }
        } catch (\Exception $e) {
            Log::error('Message: ' . $e->getMessage() . ' ---Line: ' . $e->getLine());
            return redirect()->route('management.login')->with('status_fail', 'Đổi mật khẩu thất bại !');
        }
    }
}
