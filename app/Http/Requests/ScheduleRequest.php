<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScheduleRequest extends FormRequest
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
        if ($this->routeIs('company.scheduleInterviewStore')) {
            return [
                'job_id' => 'required|exists:jobs,id',
                'user_ids' => 'required',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'location' => 'required_if:type,' . TYPE_SCHEDULE_OFF . '|max:255',
                'startDate' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $companyId = auth()->guard('admin')->id();

                        $existingSchedules = \App\Models\ScheduleInterview::where('company_id', $companyId)->get();
                        foreach ($existingSchedules as $schedule) {
                            if ($value >= $schedule->start_date && $value < $schedule->end_date) {
                                $fail('Bạn đã có lịch phỏng vấn trong khoảng thời gian này.');
                                return;
                            }

                            if (request('endDate') > $schedule->start_date && $value < $schedule->start_date) {
                                $fail('Bạn đã có lịch phỏng vấn trong khoảng thời gian này.');
                                return;
                            }
                        }
                    }
                ],
                'endDate' => [
                    'nullable',
                    'date',
                    'after:startDate',
                    function ($attribute, $value, $fail) {
                        $companyId = auth()->guard('admin')->id();
                        $existingSchedules = \App\Models\ScheduleInterview::where('company_id', $companyId)->get();

                        foreach ($existingSchedules as $schedule) {
                            if ($value > $schedule->start_date && $value <= $schedule->end_date) {
                                $fail('Thời gian kết thúc trùng với một lịch khác.');
                                return;
                            }
                        }
                    }
                ],

                'type' => 'required|in:' . TYPE_SCHEDULE_OFF . ',' . TYPE_SCHEDULE_ON,
            ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ]));
    }
}
