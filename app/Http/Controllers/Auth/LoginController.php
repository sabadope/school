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
            // Basic input sanitization
            $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
            $password = trim($request->password); // Remove whitespace

            // Additional validation rules
            $validator = Validator::make($request->all(), [
                'email'    => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' // Strict email format
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                ],
            ]);

            if ($validator->fails()) {
                Toastr::error('Invalid credentials. Please check your email and password.','Error');
                return redirect()->back()->withInput();
            }

            // Rate limiting
            if ($this->hasTooManyLoginAttempts($request)) {
                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );
                Toastr::error('Invalid credentials. Please try again in ' . ceil($seconds / 60) . ' minutes.','Error');
                return redirect()->back();
            }

            // Use strict comparison and prepared statements (Laravel handles this)
            if (Auth::attempt(['email' => $email, 'password' => $password], $request->filled('remember'))) {
                $this->clearLoginAttempts($request);
                $user = Auth::User();
                
                // Additional security check
                if (!$user || $user->status !== 'Active') {
                    Auth::logout();
                    Toastr::error('Invalid credentials. Please check your email and password.','Error');
                    return redirect('login');
                }

                // Check if password needs to be updated
                if (strlen($user->password) < 60) {
                    Toastr::warning('Please update your password to meet new security requirements.','Warning');
                }
                
                // Set session data
                $sessionData = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_id' => $user->user_id,
                    'join_date' => $user->join_date,
                    'phone_number' => $user->phone_number,
                    'status' => $user->status,
                    'role_name' => $user->role_name,
                    'avatar' => $user->avatar,
                    'position' => $user->position,
                    'department' => $user->department
                ];

                foreach ($sessionData as $key => $value) {
                    Session::put($key, $value);
                }

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
