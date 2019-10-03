<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
          'ci' => ['required', 'numeric', 'digits_between:6,8', Rule::unique('users')->ignore($this->input('id'))],
          'first_name' => ['required', 'min:2', 'max:50'],
          'last_name' => ['required', 'min:2', 'max:50'],
          'place_birth' => ['required'],
          'nacionality' => ['required'],
          'birthdate' => ['required', 'date'],
          'gender' => ['required'],
          'address' => ['required'],
          'phone' => ['required', 'numeric'],
          'email' => ['required', 'email', Rule::unique('users')->ignore($this->input('id'))],
          // 'type_user' => 'required',
          'faculty_id' => 'required_if:type_user,2,3'
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
          'ci.required' => 'Por favor, ingrese su cédula',
          'ci.numeric' => 'Su cédula debe contener solo caracteres numéricos',
          'ci.digits_between' => 'Su cédula debe tener mínimo 6 dígitos',
          'ci.unique' => 'La cédula ingresada ya se encuentra en uso',

          'first_name.required' => 'Por favor, ingrese su nombre',
          'first_name.min' => 'Su nombre debe tener mínimo 2 caracteres',
          'first_name.max' => 'Su nombre debe tener máximo 50 caracteres',

          'last_name.required' => 'Por favor, ingrese su apellido',
          'last_name.min' => 'Su apellido debe tener mínimo 2 caracteres',
          'last_name.max' => 'Su apellido debe tener máximo 50 caracteres',

          'place_birth.required' => 'Por favor, ingrese su lugar de nacimiento',

          'nacionality.required' => 'Por favor, ingrese su nacionalidad',

          'birthdate.required' => 'Por favor, ingrese su fecha de nacimiento',

          'gender.required' => 'Por favor, ingrese su genero',

          'address.required' => 'Por favor, ingrese su dirección',

          'phone.required' => 'Por favor, ingrese su teléfono',
          'phone.numeric' => 'Su telefono debe contener solo caracteres numéricos',

          'email.required' => 'Por favor, ingrese su email',
          'email.email' => 'Por favor, ingrese un email válido',
          'email.unique' => 'El email ingresado ya se encuentra en uso',

          'faculty_id.required_if' => 'El tipo de usuario seleccionado requiere una Facultad'
        ];
    }
}
