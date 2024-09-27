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
            'file_name' => 'required|string|max:255',
            'path' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'file_name.required' => 'file_name is required ',
            'path.required' => 'Path is required ',

        ];
    }
}
