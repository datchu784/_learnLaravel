<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
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
            'product_id' => 'required|integer|max:10000',
            'quantity' => 'required|integer|max:10000',

        ];
    }
    public function messages()
    {
        return [
            'product_id' => 'Quantity is required',
            'quantity' => 'Quantity is required',


        ];
    }
}
