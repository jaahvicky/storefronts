<?php

namespace App\Http\Requests\OwnerPortal;

use App\Http\Requests\Request;

class UpdateStoreSetupContactDetailsRequest extends Request
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
            "firstname" => ['required', 'min:3', 'max:50'],
            "lastname" => ['required', 'min:3', 'max:50'],
            "street_address_1" => ['required', 'min:6', 'max:50'],
            "street_address_2" => ['max:50'],
            "suburb" => ['max:50'],
            "city" => ['required'],
            "country" => ['required', 'max:50'],
            "email" => ['email', 'email.store.unique','max:50','required'],
            "phone" => ['numeric','digits_between:4,10', 'phone.store.unique', 'zim.phone']
        ];
    }
}
