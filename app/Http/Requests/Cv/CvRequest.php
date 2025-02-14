<?php

namespace App\Http\Requests\Cv;

use Illuminate\Foundation\Http\FormRequest;

class CvRequest extends FormRequest
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
        $rules = [
            'template' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'position_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:11',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'introduce' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Experience
            'company_name.*' => 'required|string|max:255',
            'position.*' => 'required|string|max:255',
            'start_date_exp.*' => 'required|date',
            'end_date_exp.*' => 'required|date|after_or_equal:start_date_exp.*',
            'description.*' => 'nullable|string|max:1000',

            // Education
            'school.*' => 'required|string|max:255',
            'major.*' => 'required|string|max:255',
            'degree.*' => 'required|string|max:255',
            'start_date_education.*' => 'required|date',
            'end_date_education.*' => 'required|date|after_or_equal:start_date_education.*',

            // Referrer
            'contact_name.*' => 'required|string|max:255',
            'contact_company_name.*' => 'required|string|max:255',
            'contact_position.*' => 'required|string|max:255',
            'contact_phone.*' => 'required|string|max:11',

            // Skill & Certificate
            'skills' => 'nullable|string|max:1000',
            'certifications' => 'nullable|string|max:1000',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'template.required' => 'Mẫu CV là bắt buộc.',
            'template.string' => 'Mẫu CV phải là chuỗi ký tự.',
            'template.max' => 'Mẫu CV không được vượt quá :max ký tự.',

            'title.required' => 'Tiêu đề hồ sơ là bắt buộc.',
            'title.string' => 'Tiêu đề hồ sơ phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề hồ sơ không được vượt quá :max ký tự.',

            'name.required' => 'Họ và tên là bắt buộc.',
            'name.string' => 'Họ và tên phải là chuỗi ký tự.',
            'name.max' => 'Họ và tên không được vượt quá :max ký tự.',

            'position_name.required' => 'Vị trí là bắt buộc.',
            'position_name.string' => 'Vị trí phải là chuỗi ký tự.',
            'position_name.max' => 'Vị trí không được vượt quá :max ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá :max ký tự.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 11 ký tự.',

            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',

            'birthdate.required' => 'Ngày sinh là bắt buộc.',
            'birthdate.date' => 'Ngày sinh không đúng định dạng.',

            'introduce.string' => 'Mục tiêu nghề nghiệp phải là chuỗi ký tự.',
            'introduce.max' => 'Mục tiêu nghề nghiệp không được vượt quá :max ký tự.',

            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',

            // Kinh nghiệm làm việc
            'company_name.*.required' => 'Tên công ty là bắt buộc.',
            'company_name.*.string' => 'Tên công ty phải là chuỗi ký tự.',
            'company_name.*.max' => 'Tên công ty không được vượt quá :max ký tự.',

            'position.*.required' => 'Vị trí là bắt buộc.',
            'position.*.string' => 'Vị trí phải là chuỗi ký tự.',
            'position.*.max' => 'Vị trí không được vượt quá :max ký tự.',

            'start_date_exp.*.required' => 'Thời gian bắt đầu là bắt buộc.',
            'start_date_exp.*.date' => 'Thời gian bắt đầu không đúng định dạng.',

            'end_date_exp.*.required' => 'Thời gian kết thúc là bắt buộc.',
            'end_date_exp.*.date' => 'Thời gian kết thúc không đúng định dạng.',
            'end_date_exp.*.after_or_equal' => 'Thời gian kết thúc phải sau hoặc bằng ngày bắt đầu.',

            'description.*.string' => 'Mô tả công việc phải là chuỗi ký tự.',
            'description.*.max' => 'Mô tả công việc không được vượt quá :max ký tự.',

            // Học vấn
            'school.*.required' => 'Tên trường là bắt buộc.',
            'school.*.string' => 'Tên trường phải là chuỗi ký tự.',
            'school.*.max' => 'Tên trường không được vượt quá :max ký tự.',

            'major.*.required' => 'Ngành học là bắt buộc.',
            'major.*.string' => 'Ngành học phải là chuỗi ký tự.',
            'major.*.max' => 'Ngành học không được vượt quá :max ký tự.',

            'degree.*.required' => 'Loại tốt nghiệp là bắt buộc.',
            'degree.*.string' => 'Loại tốt nghiệp phải là chuỗi ký tự.',
            'degree.*.max' => 'Loại tốt nghiệp không được vượt quá :max ký tự.',

            'start_date_education.*.required' => 'Thời gian bắt đầu là bắt buộc.',
            'start_date_education.*.date' => 'Ngày bắt đầu học không đúng định dạng.',

            'end_date_education.*.required' => 'Thời gian kết thúc là bắt buộc.',
            'end_date_education.*.date' => 'Ngày kết thúc học không đúng định dạng.',
            'end_date_education.*.after_or_equal' => 'Ngày kết thúc học phải sau hoặc bằng ngày bắt đầu.',

            // Người giới thiệu
            'contact_name.*.required' => 'Tên người giới thiệu là bắt buộc.',
            'contact_name.*.string' => 'Tên người giới thiệu phải là chuỗi ký tự.',
            'contact_name.*.max' => 'Tên người giới thiệu không được vượt quá :max ký tự.',

            'contact_company_name.*.required' => 'Tên công ty là bắt buộc.',
            'contact_company_name.*.string' => 'Tên công ty người giới thiệu phải là chuỗi ký tự.',
            'contact_company_name.*.max' => 'Tên công ty người giới thiệu không được vượt quá :max ký tự.',

            'contact_position.*.required' => 'Chức vụ là bắt buộc.',
            'contact_position.*.string' => 'Chức vụ người giới thiệu phải là chuỗi ký tự.',
            'contact_position.*.max' => 'Chức vụ người giới thiệu không được vượt quá :max ký tự.',

            'contact_phone.*.required' => 'Số điện thoại là bắt buộc.',
            'contact_phone.*.string' => 'Số điện thoại người giới thiệu phải là chuỗi ký tự.',
            'contact_phone.*.max' => 'Số điện thoại người giới thiệu không được vượt quá :max ký tự.',

            // Kỹ năng & Chứng chỉ
            'skills.string' => 'Kỹ năng phải là chuỗi ký tự.',
            'skills.max' => 'Kỹ năng không được vượt quá :max ký tự.',

            'certifications.string' => 'Chứng chỉ phải là chuỗi ký tự.',
            'certifications.max' => 'Chứng chỉ không được vượt quá :max ký tự.',
        ];
    }
}
