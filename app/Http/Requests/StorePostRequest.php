<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'description' => 'required|string|max:255|not_in:something,cursing'
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
