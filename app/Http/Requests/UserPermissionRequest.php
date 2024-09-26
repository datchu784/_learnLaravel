<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPermissionRequest extends FormRequest
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
            'user_id' => 'required|integer|max:10000',
            'permission_id' => 'required|integer|max:10000',

        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'user_id is required ',
            'permission_id.required' => 'permission_id is required ',

        ];
    }
}
