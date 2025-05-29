<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
    * Where to redirect users after login.
    *
    * @var string
    */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }
    /** index page login */
    public function login()
    {
        return view('auth.login');
    }

    /** login with databases */
    public function authenticate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|string|email|max:255',
                'password' => ['required', 'string', 'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                ],
            ]);

            if ($validator->fails()) {
                Toastr::error('Invalid credentials. Please check your email and password.','Error');
                return redirect()->back()->withInput();
            }
        
            DB::beginTransaction();
            
            // Sanitize inputs
            $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
            $password = $request->password;

            // Rate limiting
            if ($this->hasTooManyLoginAttempts($request)) {
                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );
                Toastr::error('Invalid credentials. Please try again in ' . ceil($seconds / 60) . ' minutes.','Error');
                return redirect()->back();
            }

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $this->clearLoginAttempts($request);
                /** get session */
                $user = Auth::User();
                
                // Check if password needs to be updated
                if (strlen($user->password) < 60) { // Check if password is not hashed with new algorithm
                    Toastr::warning('Please update your password to meet new security requirements.','Warning');
                }
                
                Session::put('name', $user->name);
                Session::put('email', $user->email);
                Session::put('user_id', $user->user_id);
                Session::put('join_date', $user->join_date);
                Session::put('phone_number', $user->phone_number);
                Session::put('status', $user->status);
                Session::put('role_name', $user->role_name);
                Session::put('avatar', $user->avatar);
                Session::put('position', $user->position);
                Session::put('department', $user->department);
                Toastr::success('Login successfully :)','Success');
                return redirect()->route('home');
            } else {
                $this->incrementLoginAttempts($request);
                Toastr::error('Invalid credentials. Please check your email and password.','Error');
                return redirect('login');
            }
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Invalid credentials. Please check your email and password.','Error');
            return redirect()->back();
        }
    }

    /** logout */
    public function logout( Request $request)
    {
        Auth::logout();
        // forget login session
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('user_id');
        $request->session()->forget('join_date');
        $request->session()->forget('phone_number');
        $request->session()->forget('status');
        $request->session()->forget('role_name');
        $request->session()->forget('avatar');
        $request->session()->forget('position');
        $request->session()->forget('department');
        $request->session()->flush();

        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }

}
