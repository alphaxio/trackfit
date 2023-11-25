<?php

namespace App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaymentRequest extends FormRequest
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
            'subscription_id'       =>  ['bail', 'required', 'numeric', 'min:0' ,'not_in:0'],
            'transaction_id'        =>  ['bail', 'required', 'string',  'min:1'],
            // 'amount'                =>  ['bail', 'required', 'numeric', 'min:1' ,'not_in:0'],
            'payment_method'        =>  ['bail', 'required', 'string'],
            'payment_type'          =>  ['bail', 'nullable', 'string'],
            'payment_response'      =>  ['bail', 'nullable'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 400));
    }
}
