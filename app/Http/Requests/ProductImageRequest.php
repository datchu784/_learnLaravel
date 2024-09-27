<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
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
            'product_id'=> 'required|max:10000',
            'file' => 'required|max:255',

        ];
    }
    public function messages()
    {
        return [
            'product_id.reqired' => 'Product_id is required',
            'file.required' => 'File is required ',


        ];
    }
}
