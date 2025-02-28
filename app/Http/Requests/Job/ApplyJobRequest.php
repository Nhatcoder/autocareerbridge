<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplyJobRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'job_id' => 'required',
            'cv_id' => 'required_without:file_cv',
            'file_cv' => 'required_without:cv_id|file|mimes:pdf|max:2048',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'name' => 'nullable|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'job_id.required' => 'Vui lòng chọn công việc ứng tuyển',
            'cv_id.required_without' => 'Vui lòng chọn hồ sơ ứng tuyển hoặc tải lên CV mới',
            'file_cv.required_without' => 'Vui lòng chọn hồ sơ ứng tuyển hoặc tải lên CV mới',
            'file_cv.file' => 'File CV không hợp lệ',
            'file_cv.mimes' => 'File CV phải có định dạng PDF',
            'file_cv.max' => 'File CV không được vượt quá 5MB',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số',
            'phone.max' => 'Số điện thoại không được vượt quá 15 số',
            'name.max' => 'Họ và tên không quá 255 ký tự',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ]));
    }
}
