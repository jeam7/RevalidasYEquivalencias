<?php
namespace App\Http\Controllers\Admin;
use Backpack\Base\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Validator;

class RegisterController extends Controller
{
    protected $data = [];

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
    protected function validatorStep1(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';

        return Validator::make($data, [
            'ci' => ['required', 'numeric', 'digits_between:6,8', Rule::unique('users')],
            'first_name' => ['required', 'min:2', 'max:50'],
            'last_name' => ['required', 'min:2', 'max:50'],
            'email' => ['required', 'email', Rule::unique('users')],
        ],
        [
          'ci.required' => 'Por favor, ingrese su cédula',
          'ci.numeric' => 'Su cédula debe contener solo caracteres numéricos',
          'ci.digits_between' => 'Su cédula debe tener mínimo 6 digitos',
          'ci.unique' => 'La cédula ingresada ya se encuentra en uso',
          //
          'first_name.required' => 'Por favor, ingrese su nombre',
          'first_name.min' => 'Su nombre debe tener mínimo 2 caracteres',
          'first_name.max' => 'Su nombre debe tener máximo 50 caracteres',
          //
          'last_name.required' => 'Por favor, ingrese su apellido',
          'last_name.min' => 'Su apellido debe tener mínimo 2 caracteres',
          'last_name.max' => 'Su apellido debe tener máximo 50 caracteres',
          //
          'email.required' => 'Por favor, ingrese su email',
          'email.email' => 'Por favor, ingrese un email valido',
          'email.unique' => 'El email ingresado ya se encuentra en uso',
        ]
      );
    }

    protected function validatorStep2(array $data)
    {
        return Validator::make($data, [
            'place_birth' => ['required'],
            'nacionality' => ['required'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'min:6', 'confirmed']
        ],
        [
          'place_birth.required' => 'Por favor, ingrese su lugar de nacimiento',
          //
          'nacionality.required' => 'Por favor, ingrese su nacionalidad',
          //
          'birthdate.required' => 'Por favor, ingrese su fecha de nacimiento',
          //
          'gender.required' => 'Por favor, ingrese su género',
          //
          'address.required' => 'Por favor, ingrese su dirección',
          //
          'phone.required' => 'Por favor, ingrese su teléfono',
          'phone.numeric' => 'Su télefono debe contener solo caracteres numéricos',
          //
          'password.required' => 'Por favor, ingrese su contraseña',
          'password.min' => 'Su contraseña tener mínimo 6 caractes',
          'password.confirmed' => 'Confirmación de contraseña incorrecta',
          'confirm_password.same' => 'Confirmación de contraseña incorrecta'
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
          'email' => $data['email']
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

        $this->validatorStep1($request->all())->validate();

        $subject = "Registro de usuario";
        $for = $request->email;
        Mail::send('sendEmailRegisterStep2', $request->all(), function($msj) use($subject,$for){
            $msj->from("jeanmarchena31@gmail.com","RyE");
            $msj->subject($subject);
            $msj->to($for);
        });
        $this->create($request->all());
        return redirect('admin/successSendRegisterMail');
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

    public function showRegistrationFormStep2()
    {
      $email = Input::get('email');
      $user = User::where('email', $email)->first();
      if ($user->password) {
          abort(404, "El Usuario ya se encuentra registrado.");
      }else {
        $this->data['title'] = trans('backpack::base.register');
        return view('postCorreo', $user);
      }

    }

    public function registerStep2(Request $request)
    {
      $this->validatorStep2($request->all())->validate();
      $user = User::where('email', $request->email)->first();
      $user->place_birth = $request->place_birth;
      $user->nacionality = $request->nacionality;
      $user->birthdate = $request->birthdate;
      $user->gender = $request->gender;
      $user->address = $request->address;
      $user->phone = $request->phone;
      $user->password = Hash::make($request->password);
      $user->type_user = 4;
      $user->save();
      return redirect('/admin/successRegisterUser');
    }
}
