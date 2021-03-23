<?php

namespace App\Http\Requests\BackOffice;

use App\Http\Requests\Request;

class UpdateAccountRequest extends Request
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
            
            //store_contact_details
            'firstname' => ['required', 'min:3', 'max:50'],
            'lastname' => ['required', 'min:3', 'max:50'],
            'street_address_1' => ['required', 'min:6', 'max:50'],
            'street_address_2' => ['max:50'],
            'suburb' => ['max:50'],
            'city' => ['required'], // , 'min:3', 'max:50'
            'country' => ['required', 'max:50'],
            'phone' => ['required', 'zim.phone'],
            'email' => ['email', 'required', 'min:6', 'max:50'],
            
        ];
    }
}
