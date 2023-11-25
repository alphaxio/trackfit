<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateStatusRequest extends FormRequest
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
            'exercise_status' => ['bail', 'nullable', 'string', 'in:MISS,PASS,EXERCISED'],
            'exercise_type'   => ['bail', 'nullable', 'string', 'in:REGULAR,IRREGULAR'],
        ];
    }
}
