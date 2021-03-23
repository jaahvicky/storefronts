<?php

namespace App\Http\Requests\BackOffice;

use App\Http\Requests\Request;

class UpdateStoreDetailsRequest extends Request
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
        $store_id = $this->input('store_id');
        
        return [
            
            //store_details
            'name' => ['required', 'min:6', 'unique:stores,name,'.$store_id, 'max:70'],
            'street_address_1' => ['required', 'min:6', 'max:50'],
            //'street_address_2' => ['max:50'],
            "l1" => ['required'],
            "l2" => ['required'],
            'suburb' => ['max:50'],
            'city' => ['required'], // 'min:3', 'max:50'
            'country' => ['required', 'max:50'],
            'phone' => ['required', 'zim.phone'],
            'email' => ['max:50', 'email'],
            'collection_hours' => ['max:200'],
        ];
    }

    public function messages()
    {
        return [
            'l1.required'               => 'The street address must exist.',
            'l2.required'               => 'The street address must exist.',
            'street_address_1.required' => 'The street address is required.',
            'street_address_1.min'      => 'The street address must be at least :min characters.',
            'street_address_1.max'      => 'The street address field may not be greater than :max characters.'
        ];
    }
}
