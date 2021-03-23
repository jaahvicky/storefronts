<?php

namespace App\Http\Requests\BackOffice;

use App\Http\Requests\Request;

class UpdateStoreAboutRequest extends Request
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
            'exerpt' => ['required', 'min:6', 'max:100'],
            'description' => ['required', 'min:6', 'max:3000'],
        ];
    }
}
