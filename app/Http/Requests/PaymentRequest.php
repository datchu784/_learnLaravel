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
            //'payment.amount' => 'required|numeric|min:0',
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

            // 'payment.recipient_id.required' => 'recipient_id is required',
            // //'sender_id' => 'sender_id is required',
            // //'amount.required' => 'amount is required',
            // 'payment_method.required' => 'payment_method is required',
            // 'status.required' => 'status is required',


        ];
    }
}
