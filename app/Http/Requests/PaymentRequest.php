<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            'recipient_id' => 'required|integer|max:10000',
            //'sender_id' => 'required|integer|max:10000',
            'amount' => 'required|numeric|max:10000',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|string|max:255',

        ];
    }
    public function messages()
    {
        return [

            'recipient_id.required' => 'recipient_id is required',
            //'sender_id' => 'sender_id is required',
            'amount.required' => 'amount is required',
            'payment_method.required' => 'payment_method is required',
            'status.required' => 'status is required',


        ];
    }
}
