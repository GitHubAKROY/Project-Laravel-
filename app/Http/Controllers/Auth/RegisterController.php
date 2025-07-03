<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Utilities\Overrider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller {
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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
        Overrider::load("Settings");
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm() {
        if (get_option('member_signup') != 1) {
            return back();
        }
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        config(['recaptchav3.sitekey' => get_option('recaptcha_site_key')]);
        config(['recaptchav3.secret' => get_option('recaptcha_secret_key')]);

        return Validator::make($data, [
            'name'                 => ['required', 'string', 'max:50'],
            'workspace'            => ['required', 'unique:tenants,slug', 'alpha_dash', 'max:30'],
            'email'                => [
                'required',
                'string',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('tenant_owner', 1)
                        ->orWhere('user_type', 'superadmin');
                }),
            ],
            'country_code'         => ['required'],
            'mobile'               => ['required', 'numeric', 'unique:users,mobile'],
            'password'             => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => get_option('enable_recaptcha', 0) == 1 ? 'required|recaptchav3:register,0.5' : '',
        ], [
            //'agree.required'                   => _lang('You must agree with our privacy policy and terms of use'),
            'g-recaptcha-response.recaptchav3' => _lang('Recaptcha error!'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data) {

        $tenant             = new Tenant();
        $tenant->slug       = $data['workspace'];
        $tenant->name       = $data['name'];
        $tenant->status     = 1;
        $tenant->package_id = $data['package_id'] ?? null;
        $tenant->save();

        return User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'country_code'    => $data['country_code'],
            'mobile'          => $data['mobile'],
            'user_type'       => 'admin',
            'status'          => 1,
            'profile_picture' => 'default.png',
            'password'        => Hash::make($data['password']),
            'tenant_id'       => $tenant->id,
            'tenant_owner'    => 1,
        ]);
    }

    private function redirectTo() {
        return route('dashboard.index', ['tenant' => auth()->user()->tenant->slug]);
    }
}
