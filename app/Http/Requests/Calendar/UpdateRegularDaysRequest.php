<?php

namespace App\Http\Requests\Calendar;

use App\Rules\DayOfWeekRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRegularDaysRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'regular_exercise_days'       => ['bail', 'required', 'array', 'min:1'],
            'regular_exercise_days.*'     => ['bail', 'required', 'array', 'min:1'],
            'regular_exercise_days.*.day' => ['bail', 'required', 'string', new DayOfWeekRule()],
            'exercise_schedules'          => ['bail', 'nullable', 'array', 'min:1'],
            'exercise_schedules.*'        => ['bail', 'nullable', 'array', 'min:1'],
            'exercise_schedules.*.day'    => ['bail', 'required', 'string', new DayOfWeekRule()],
            'exercise_schedules.*.date'   => ['bail', 'required', 'date'],
        ];
    }
}
