<?php

namespace App\Http\Requests\Schedule;

use App\Models\DailySchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePTScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'location_name'           => ['bail', 'required', 'string', 'min:1'], // required
            'trainers_name'           => ['bail', 'nullable', 'string', 'min:1'],
            'gender'                  => ['bail', 'nullable', 'string', 'in:male,female', 'min:1'],
            'session_total_count'     => ['bail', 'required', 'numeric', 'max:9999'], // required
            'amount'                  => ['bail', 'nullable', 'numeric', 'min:1', 'max:9999999999'], // required
            'start_date'              => ['bail', 'required', 'date_format:Y-m-d'],
            'session_current_count'   => ['bail', 'required', 'numeric', 'lt:session_total_count'], // required
            'weight_before'           => ['bail', 'required', 'numeric', 'min:1', 'max:999'], // required
            'target_weight'           => ['bail', 'nullable', 'numeric', 'min:1', 'max:999'],
            'regular_exercise_days'   => ['bail', 'nullable', 'array', 'min:1'],
            'regular_exercise_days.*' => ['bail', 'nullable', 'array', 'min:1'],
            'regular_exercise_days.*.day' => [
                'required',
                'string',
                Rule::in(array_map('strtolower', DailySchedule::$DAYS_OF_WEEK)),
            ],
            'exercise_schedules' => ['bail', 'nullable', 'array']
        ];
    }
}
