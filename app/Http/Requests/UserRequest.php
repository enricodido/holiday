<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'lastname' => 'required|max:50',
            'name' => 'required|max:50',
            'email' => 'required|max:200|email:rfc',
            'role' => 'required',
        ];

        $rules['password'] = 'min:6';
        if($this->route()->getActionMethod() === 'store') // create
            $rules['password'] .= '|required';
        if($this->route()->getActionMethod() === 'update') // create
            $rules['password'] .= '|nullable';

        return $rules;
    }

    function attributes()
    {
        return [
            'lastname' => __('user.lastname'),
            'name' => __('user.name'),
            'role' => __('role.role'),
        ];
    }
}
