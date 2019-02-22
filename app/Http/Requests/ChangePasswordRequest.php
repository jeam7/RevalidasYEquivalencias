<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // check old password matches
            if (!Hash::check($this->input('old_password'), backpack_auth()->user()->password)) {
                $validator->errors()->add('old_password', trans('backpack::base.old_password_incorrect'));
            }
        });
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Por favor, ingrese su contrasena antigua',
            'new_password.required' => 'Por favor, ingrese su nueva contrasena',
            'new_password.min' => 'Su nueva contrasena debe tener minimo 6 caracteres',
            'confirm_password.same' => 'Confirmacion de nueva contrasena incorrecta'
        ];
    }
}
