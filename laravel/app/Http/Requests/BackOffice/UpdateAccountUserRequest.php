<?php

namespace App\Http\Requests\BackOffice;

use App\Http\Requests\Request;
use Auth;

class UpdateAccountUserRequest extends Request
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
            'password' => ['required', 'auth'],
            'new_password' => ['required', 'min:6'],
            'new_password_confirm' => ['required', 'min:6', 'same:new_password']
        ];
    }
}
