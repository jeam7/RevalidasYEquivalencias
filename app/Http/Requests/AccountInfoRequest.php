<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountInfoRequest extends FormRequest
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
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'place_birth' => 'required',
            'nacionality' => 'required',
            'birthdate' => 'required|date',
            'address' => 'required',
            'phone' => 'required|numeric',
            'email' => ['required', 'email', Rule::unique('users')->ignore(backpack_user()->id)]
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
          'first_name.required' => 'Por favor, ingrese su nombre',
          'first_name.min' => 'Su nombre debe tener minimo 2 caracteres',
          'first_name.max' => 'Su nombre debe tener maximo 50 caracteres',
          'last_name.required' => 'Por favor, ingrese su apellido',
          'last_name.min' => 'Su apellido debe tener minimo 2 caracteres',
          'last_name.max' => 'Su apellido debe tener maximo 50 caracteres',
          'place_birth.required' => 'Por favor, ingrese su lugar de nacimiento',
          'nacionality.required' => 'Por favor, ingrese su nacionalidad',
          'birthdate.required' => 'Por favor, ingrese su fecha de nacimiento',
          'address.required' => 'Por favor, ingrese su direccion',
          'phone.required' => 'Por favor, ingrese su telefono',
          'phone.numeric' => 'Su telefono debe contener solo caracteres numericos',
          'email.required' => 'Por favor, ingrese su email',
          'email.email' => 'Por favor, ingrese un email valido',
          'email.unique' => 'El email ingresado ya se encuentra en uso'
        ];
    }
}
