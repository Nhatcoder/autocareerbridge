<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\ScheduleInterview;

class ScheduleInterviewUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'job_id' => 'required|exists:jobs,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề cuộc họp không được để trống',
            'job_id.required' => 'Công việc không được để trống',
            'start_date.required' => 'Thời gian bắt đầu không được để trống',
            'end_date.required' => 'Thời gian kết thúc không được để trống',
            'start_date.after' => 'Thời gian bắt đầu phải lớn hơn hiện tại',
            'end_date.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu',
            'job_id.exists' => 'Công việc không hợp lệ',
            'user_ids.required' => 'Vui lòng chọn ít nhất một ứng viên',
            'user_ids.*.exists' => 'Người dùng không hợp lệ',
        ];
    }


    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $companyId = auth()->guard('admin')->user()->company->id;
            $scheduleId = $this->route('id');
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');

            $exists = ScheduleInterview::where('company_id', $companyId)
                ->where('id', '!=', $scheduleId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where([
                        ['start_date', '<=', $endDate],
                        ['end_date', '>=', $startDate],
                    ]);
                })
                ->exists();


            if ($exists) {
                $validator->errors()->add('start_date', 'Lịch phỏng vấn bị trùng thời gian!');
            }
        });
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $validator->errors()
        ], 422));
    }
}
