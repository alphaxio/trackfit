<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateNoteRequest extends FormRequest
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
            'note' => ['bail', 'required', 'min:1', 'max:500'],
        ];
    }
}
