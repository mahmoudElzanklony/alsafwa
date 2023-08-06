<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Users extends FormRequest
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

    public function authentication(){
        return [
          'email'=>'required',
          'password'=>'required',
        ];
    }

    public function users_data(){
        return [
            'name'=>'required|max:191',
            'email'=>'required|max:191|unique:users,email,'.$this->id.',id',
            'password'=>'max:191|nullable',
            'address'=>'required|max:191',
            'phone'=>'required|max:191',
            'control'=>'nullable',
        ];
    }

    public function rules()
    {
        return request()->path() == "login" ? $this->authentication() : $this->users_data();
    }
    public function attributes()
    {
        return [
          'name'=>trans('attributes.name'),
          'email'=>trans('attributes.email'),
          'password'=>trans('attributes.password'),
          'address'=>trans('attributes.address'),
          'phone'=>trans('attributes.phone'),
        ];
    }

    public function messages()
    {
        return [
          'name:required'=>trans('validation.required'),
          'email:required'=>trans('validation.required'),
          'email:unique'=>trans('validation.unique'),
          'password:required'=>trans('validation.password'),
          'password:address'=>trans('validation.address'),
          'password:phone'=>trans('validation.phone'),
        ];
    }
}
