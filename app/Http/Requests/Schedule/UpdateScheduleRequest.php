<?php

namespace App\Http\Requests\Schedule;

use App\Models\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
        $schedule = Schedule::where('id', $this->id)->where('user_id', auth()->user()->id)->first();

        if (!$schedule) {
            return []; // No rules needed, as schedule doesn't exist
        }

        if ($schedule && $schedule->exercise_type == Schedule::$PT) {
            return [
                'location_name'           => ['bail', 'required', 'string', 'min:1'], // required
                'trainers_name'           => ['bail', 'nullable', 'string', 'min:1'],
                'gender'                  => ['bail', 'nullable', 'string', 'in:male,female', 'min:1'],
                'session_total_count'     => ['bail', 'required', 'numeric', 'max:9999'], // required
                'amount'                  => ['bail', 'required', 'numeric', 'min:1', 'max:9999999999'], // required
                'session_current_count'   => ['bail', 'required', 'numeric', 'lt:session_total_count'], // required
                'target_weight'           => ['bail', 'required', 'numeric', 'min:1', 'max:999'], // required
                'start_date'              => ['bail', 'required', 'date_format:Y-m-d'],
                'weight_before'           => ['bail', 'required', 'numeric', 'min:1', 'max:999'], // required
            ];
        } elseif ($schedule && $schedule->exercise_type == Schedule::$PE) {
                return [
                'location_name'    => ['bail', 'nullable', 'string', 'min:1'],
                'amount'           => ['bail', 'nullable', 'numeric'],
                'number_of_months' => ['bail', 'nullable', 'numeric', 'max:160'],
                'target_weight'    => ['bail', 'nullable', 'numeric', 'min:1'],
                'start_date'       => ['bail', 'required', 'date_format:Y-m-d'],
                'weight_before'    => ['bail', 'required', 'numeric', 'min:1', 'max:999'], // required
            ];
        }
    }
}
