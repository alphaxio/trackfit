<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateTypeRequest extends FormRequest
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
            'status' => ['bail', 'nullable', 'string', 'in:REGULAR,IRREGULAR'],
        ];
    }
}
