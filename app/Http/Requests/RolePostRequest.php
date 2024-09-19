<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolePostRequest extends FormRequest
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
            'description' => 'nullable|string',

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required ',
            'description.required' => 'Description is required ',
            
        ];
    }
}
