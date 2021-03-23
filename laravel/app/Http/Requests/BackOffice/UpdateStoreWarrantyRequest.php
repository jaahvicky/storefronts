<?php

namespace App\Http\Requests\BackOffice;

use App\Http\Requests\Request;

class UpdateStoreWarrantyRequest extends Request
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
            'warranty' => ['required', 'min:6', 'max:3000'],
        ];
    }
}
