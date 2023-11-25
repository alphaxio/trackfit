<?php

namespace App\Http\Requests\Schedule;

use App\Models\DailySchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePEScheduleRequest extends FormRequest
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
            'location_name'           => ['bail', 'required', 'string', 'min:1'],
            'amount'                  => ['bail', 'nullable', 'numeric', 'min:1', 'max:9999999999'], // required
            'number_of_months'        => ['bail', 'nullable', 'numeric', 'max:160'],
            'start_date'              => ['bail', 'required', 'date_format:Y-m-d'],
            'weight_before'           => ['bail', 'required', 'numeric', 'min:1', 'max:999'],
            'target_weight'           => ['bail', 'nullable', 'numeric', 'min:1', 'max:999'],
            'regular_exercise_days'   => ['bail', 'nullable', 'array', 'min:1'],
            'regular_exercise_days.*' => ['bail', 'nullable', 'array', 'min:1'],
            'regular_exercise_days.*.day' => [
                'required',
                'string',
                Rule::in(array_map('strtolower', DailySchedule::$DAYS_OF_WEEK)),
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'regular_exercise_days.*.day.in' => 'Check all your days in exercise days.'
        ];
    }
}
