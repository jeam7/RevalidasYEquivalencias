<?php
// namespace Backpack\Base\app\Http\Controllers\Auth;
namespace App\Http\Controllers\Admin;
use Backpack\Base\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class RegisterController extends Controller
{
    protected $data = []; // the information we send to the view

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $guard = backpack_guard_name();

        $this->middleware("guest:$guard");

        // Where to redirect users after login / registration.
        $this->redirectTo = property_exists($this, 'redirectTo') ? $this->redirectTo
            : config('backpack.base.route_prefix', 'dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';

        return Validator::make($data, [
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
          'ci.required' => 'Por favor, ingrese su cedulaaaaaaaaaaa',
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
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();

        return $user->create([
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

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        // if registration is closed, deny access
        if (!config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }

        $this->data['title'] = trans('backpack::base.register'); // set the page title

        return view('backpack::auth.register', $this->data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // if registration is closed, deny access
        if (!config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }

        $this->validator($request->all())->validate();

        $this->guard()->login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return backpack_auth();
    }
}
