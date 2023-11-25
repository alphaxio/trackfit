<?php

namespace App\Http\Requests\Record;

use Illuminate\Foundation\Http\FormRequest;

class RecordListRequest extends FormRequest
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
            'date' => ['bail', 'nullable', 'date'],
            'schedule_ids' => 'array',
            'schedule_ids.*' => 'exists:schedules,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'schedule_ids.*.exists' => 'Selected schedule is invalid',
        ];
    }
}
