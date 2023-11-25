<?php

namespace App\Http\Requests\Progress;

use Illuminate\Foundation\Http\FormRequest;

final class UploadMediaRequest extends FormRequest
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
            'body_image'      => ['bail', 'mimes:jpeg,png,jpg,gif,svg'],
            'dinner_image'    => ['bail', 'mimes:jpeg,png,jpg,gif,svg'],
            'lunch_image'     => ['bail', 'mimes:jpeg,png,jpg,gif,svg'],
            'breakfast_image' => ['bail', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }
}
