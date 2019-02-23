<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name'                             => 'required|max:255',
            // backpack_authentication_column()   => 'required|'.$email_validation.'max:255|unique:'.$users_table,
            // 'password'                         => 'required|min:6|confirmed',
            'ci' => ['required', 'numeric', 'digits_between:6,8', Rule::unique('users')],
            'first_name' => ['required', 'min:2', 'max:50'],
            'last_name' => ['required', 'min:2', 'max:50'],
            'place_birth' => ['required'],
            'nacionality' => ['required'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'min:6', 'confirmed']
        ],
        [
          'ci.required' => 'Por favor, ingrese su cedula',
          'ci.numeric' => 'Su cedula debe contener solo caracteres numericos',
          'ci.digits_between' => 'Su cedula debe tener minimo 6 digitos',
          'ci.unique' => 'La cedula ingresada ya se encuentra en uso',

          'first_name.required' => 'Por favor, ingrese su nombre',
          'first_name.min' => 'Su nombre debe tener minimo 2 caracteres',
          'first_name.max' => 'Su nombre debe tener maximo 50 caracteres',

          'last_name.required' => 'Por favor, ingrese su apellido',
          'last_name.min' => 'Su apellido debe tener minimo 2 caracteres',
          'last_name.max' => 'Su apellido debe tener maximo 50 caracteres',

          'place_birth.required' => 'Por favor, ingrese su lugar de nacimiento',

          'nacionality.required' => 'Por favor, ingrese su nacionalidad',

          'birthdate.required' => 'Por favor, ingrese su fecha de nacimiento',

          'gender.required' => 'Por favor, ingrese su genero',

          'address.required' => 'Por favor, ingrese su direccion',

          'phone.required' => 'Por favor, ingrese su telefono',
          'phone.numeric' => 'Su telefono debe contener solo caracteres numericos',

          'email.required' => 'Por favor, ingrese su email',
          'email.email' => 'Por favor, ingrese un email valido',
          'email.unique' => 'El email ingresado ya se encuentra en uso',

          'password.required' => 'Por favor, ingrese su contrasena',
          'password.min' => 'Su contrasena tener minimo 6 caractes',
          'password.confirmed' => 'Confirmacion de contrasena incorrecta'
          // 'confirm_password.same' => 'Confirmacion de contrasena incorrecta'

        ]
      );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        dd($data);
        return User::create([
            'ci' => $data['ci'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'place_birth' => $data['place_birth'],
            'nacionality' => $data['nacionality'],
            'birthdate' => $data['birthdate'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'type_user' => 4,
            'password' => Hash::make($data['password'])
        ]);
    }

}
