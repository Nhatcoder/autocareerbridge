<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustommerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules()
    {
        if ($this->routeIs('register')) {
            return [
                'name' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
                'password' => ['required', 'min:8', 'regex:/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$@#%]).*$/'],
                'password_confirmation' => ['required', 'same:password'],
            ];
        } elseif ($this->routeIs('login')) {
            return [
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required'],
            ];
        } elseif ($this->routeIs('account.updateProfile')) {
            return [
                'name' => ['required', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . auth('web')->user()->id, 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
                'phone' => ['nullable', 'regex:/^(\+84 ?)?\d{10}$/'],
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được để trống.',
            'name.min' => 'Họ tên phải có ít nhất 3 ký tự.',
            'name.max' => 'Họ tên phải ít hơn 225 ký tự.',
            'email.regex' => 'Email không đúng định dạng.',
            'email.email' => 'Email phải là địa chỉ email hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'email.required' => 'Email không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password_confirmation.required' => 'Mật khẩu xác nhận không được để trống.',
            'password.regex' => 'Mật khẩu từ 8-25 ký tự, chứa ít nhất một chữ cái hoa, chữ cái thường, số và ký tự đặc biệt.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',
            'password_confirmation.same' => 'Mật khẩu nhập lại không khớp.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.'
        ];
    }
}
