<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class role_permission extends FormRequest
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
            'name'=>'required',
            'privillages'=>'required|array|distinct|min:1|exists:permissions,id'
        ];
    }

    public function attributes()
    {
        return [
            'name'=>trans('attributes.role'),
            'privillages'=>trans('attributes.privillages')
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>trans('validation.required'),
            'privillages.required'=>trans('validation.required'),
            'privillages.distinct'=>trans('validation.distinct'),
            'privillages.min'=>trans('validation.min'),
            'privillages.exists'=>trans('validation.exists'),
        ];
    }
}
