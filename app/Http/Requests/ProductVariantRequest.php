<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
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
            'size_id' => 'required|integer|max:255',
            'color_id' => 'required|integer|max:255',
            'price_adjustment' => 'required|numeric|max:255',
            'stock' => 'required|integer|max:255',

        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'product_id is required ',
            'size_id.required' => 'size_id is required ',
            'color_id.required' => 'color_id is required',
            'price_adjustment.required' => 'price_adjustment is required',
            'stock.required' => 'stock is required',


        ];
    }
}
