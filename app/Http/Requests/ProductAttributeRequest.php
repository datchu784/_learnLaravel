<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeRequest extends FormRequest
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
            'product_id' => 'required|integer|max:255',
            'attribute_id' => 'required|integer|max:255',
            'value' => 'required|string|max:255',

        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'product_id is required ',
            'attribute_id.required' => 'attribute_id is required ',
            'value.required' => 'value is required',


        ];
    }
}
