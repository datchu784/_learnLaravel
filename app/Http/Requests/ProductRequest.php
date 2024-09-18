<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255|not_in:something,cursing',
            'quantity' => 'required|integer|max:10000',
            'product_type_id' => 'required|integer|'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required ',
            'description.required' => 'Description is required ',
            'quantity' => 'Quantity is required',
            'product_type_id' => 'product_type_id is required'

        ];
    }
}
