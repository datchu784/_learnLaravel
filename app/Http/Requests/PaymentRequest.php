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
            'payment.amount' => 'required|numeric|min:0',
            'payment.recipient_id' => 'required|exists:users,id',
            'payment.payment_method' => 'required|string',

            'order_details' => 'required|array|min:1',
            'order_details.*.product_id' => 'required|exists:products,id',
            'order_details.*.quantity' => 'required|integer|min:1',

        ];
    }
    public function messages()
    {
        return [

            'payment.recipient_id.required' => 'payment.recipient_id is required',
            'payment.amount.required' => 'payment.amount is required',
            'payment.payment_method.required' => 'payment.payment_method is required',
            'order_details.required' => 'order_details.required is required',
            'order_details.*.product_id.required' => 'order_details.*.product_id is required',
            'order_details.*.quantity' => 'order_details.*.quantity is required',


        ];
    }
}
