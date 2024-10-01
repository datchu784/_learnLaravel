<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            //'id_role' => 'required|integer|max:10000',
            
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required ',
            'email.required' => 'Email is required ',
            'password.required' => 'Password is required',
            //'id_role.required' => 'id_role is required',


        ];
    }
}
