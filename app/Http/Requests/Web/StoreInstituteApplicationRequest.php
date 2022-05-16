<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstituteApplicationRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:institute_applications',
            'address' => 'required',
            'mobile_no' => 'required',  
            'type_of_class' => 'required',
            'description' => 'required',
        ];
    }
}
