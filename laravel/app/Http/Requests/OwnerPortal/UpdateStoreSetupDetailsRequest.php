<?php

namespace App\Http\Requests\OwnerPortal;

use App\Http\Requests\Request;

use App\Models\Store;

class UpdateStoreSetupDetailsRequest extends Request
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
        $slug = ['required', 'min:3', 'max:30', 'unique:stores,slug'];
        $username = ['required', 'min:6', 'unique:users,username', 'max:50'];
        $password = ['max:50'];
        $passwordConfirm = ['max:50', 'same:password'];
        $store_delivery  = ['required'];
        
        //If they already have a  user set up (in the session), then leave the password alone unless they go back and change it
        if (!$this->session()->has('user') && !$this->session()->has('store')) {
            $password[] = 'required';
            $password[] = 'min:6';
            $passwordConfirm[] = 'required';
            $passwordConfirm[] = 'min:6';
        }
        else if (!empty($this->input('password'))) {
            $password[] = 'min:6';
            $passwordConfirm[] = 'required';
            $passwordConfirm[] = 'min:6';
        }

        if($this->input('ownai_account') == 'account_available'){
           
          
            $username_ownai = ['required','zim.phone','integer'];
            $password_ownai = ['required','min:3', ];
           

        }else{
            $username_ownai = [''];
            $password_ownai = [''];
        }

        // if vehicle or property, do not require the store_delivery. it should be disabled then.
        // set the store_type value to default 2 - arrange with seller
        
        //if($this->input('store_type') == Store::STORE_TYPE_VEHICLES || $this->input('store_type') == Store::STORE_TYPE_PROPERTY) {
        //    $store_delivery = [''];
        //}
        
        return [
            "store_name" => ['required', 'min:6', 'max:70'],
            "store_type" => ['required', 'max:50'],
            "store_delivery" => $store_delivery,
            "ownai_account"=>['required'],
            "store_slug" => $slug,
            "street_address_1" => ['required', 'min:6', 'max:50'],
            "l1" => ['required'],
            "l2" => ['required'],
            //"street_address_2" => ['max:50'],
            "suburb" => ['max:50'],
            "city" => ['required'], // , 'min:3', 'max:50'
            "country" => ['required', 'max:50'],
            "email" => ['email','email.store.unique', 'max:50','required'],
            "phone" => ['required', 'zim.phone', 'phone.store.unique'],
            "username" => $username,
            "password" => $password,
            "password_confirm" => $passwordConfirm,
            'username_ownai'=> $username_ownai,
            'password_ownai'=>$password_ownai
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
