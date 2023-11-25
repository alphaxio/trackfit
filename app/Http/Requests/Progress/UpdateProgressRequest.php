<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateProgressRequest extends FormRequest
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
     * @return array<string, array>
     */
    public function rules(): array
    {
        return [
            'diet_control_status' => ['bail', 'nullable', 'string', 'in:MISS,PASS,RESET'],
            'exercise_time'       => ['bail', 'nullable', 'string'],
            'note'                => ['bail', 'nullable', 'min:1', 'max:500'],
            'exercise_status'     => ['bail', 'nullable', 'string', 'in:MISS,PASS,EXERCISED,RESET'],
            'type'                => ['bail', 'nullable', 'string', 'in:PT,PE'],
            'exercise_type'       => ['bail', 'nullable', 'string', 'in:REGULAR,IRREGULAR'],
            'weight'              => ['bail', 'nullable', 'integer'],
            'body_part_ids'       => ['bail', 'array'],
        ];
    }
}
