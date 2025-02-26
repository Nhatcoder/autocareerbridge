<?php

namespace App\Http\Requests\Cv;

use Illuminate\Foundation\Http\FormRequest;

class UploadCv extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file_upload_cv' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'file_upload_cv.required' => 'Vui lòng chọn file để upload.',
            'file_upload_cv.file' => 'Tập tin không hợp lệ.',
            'file_upload_cv.mimes' => 'Chỉ chấp nhận file PDF.',
            'file_upload_cv.max' => 'File không được vượt quá 5MB.',
        ];
    }
}
