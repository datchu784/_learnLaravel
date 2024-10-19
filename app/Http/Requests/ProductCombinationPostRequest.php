<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCombinationPostRequest extends FormRequest
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

            'product.product_id' => 'required|integer|max:10000',
            'product.price' => 'required|numeric|max:10000',
            'attributes.*.attribute_value_id' => 'required|string|max: 255'

        ];
    }
    public function messages()
    {
        return [

            'product_id.required' => 'product_id is required',
            'price.required' => 'price is required',
            'attributes.*.attribute_value_id' => 'attributes.*.value'


        ];
    }
}
