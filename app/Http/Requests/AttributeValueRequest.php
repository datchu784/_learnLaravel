<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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

            'attribute_id' => 'required|integer|max:10000',
            'value' => 'required|string|max:255',


        ];
    }
    public function messages()
    {
        return [

            'attribute_id.required' => 'attribute_id is required',
            'value.required' => 'value is required',


        ];
    }
}
