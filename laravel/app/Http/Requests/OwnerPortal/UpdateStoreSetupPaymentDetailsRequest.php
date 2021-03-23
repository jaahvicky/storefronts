<?php

namespace App\Http\Requests\OwnerPortal;

use App\Http\Requests\Request;

class UpdateStoreSetupPaymentDetailsRequest extends Request
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
        $accountType = $this->input('account_type');
        $validation = ['number' => ['min:6', 'max:50'], 'terms_conditions' => ['required']];
        
        if ($accountType == "merchant-acc") {
            $validation['name'] = ['min:6', 'max:50'];
        }
                
        return $validation;
    }
}
