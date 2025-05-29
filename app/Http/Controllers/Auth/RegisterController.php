<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register()
    {
        $role = DB::table('role_type_users')->get();
        return view('auth.register',compact('role'));
    }
    public function storeUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'email'     => 'required|string|email|max:255|unique:users',
                'role_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'password'  => ['required', 'string', 'min:8', 'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                ],
            ], [
                'name.required' => 'Full name is required.',
                'name.string' => 'Full name must be text.',
                'name.max' => 'Full name cannot exceed 255 characters.',
                'name.regex' => 'Full name can only contain letters and spaces.',
                
                'email.required' => 'Email address is required.',
                'email.string' => 'Email must be text.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'Email address cannot exceed 255 characters.',
                'email.unique' => 'This email address is already registered.',
                
                'role_name.required' => 'Role selection is required.',
                'role_name.string' => 'Role must be text.',
                'role_name.max' => 'Role name cannot exceed 255 characters.',
                'role_name.regex' => 'Role name can only contain letters and spaces.',
                
                'password.required' => 'Password is required.',
                'password.string' => 'Password must be text.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character (@$!%*?&).'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                
                // Check each password requirement
                $password = $request->password;
                $passwordErrors = [];
                
                if (strlen($password) < 8) {
                    $passwordErrors[] = 'Password must be at least 8 characters long.';
                }
                if (!preg_match('/[A-Z]/', $password)) {
                    $passwordErrors[] = 'Password must contain at least one uppercase letter.';
                }
                if (!preg_match('/[a-z]/', $password)) {
                    $passwordErrors[] = 'Password must contain at least one lowercase letter.';
                }
                if (!preg_match('/[0-9]/', $password)) {
                    $passwordErrors[] = 'Password must contain at least one number.';
                }
                if (!preg_match('/[@$!%*?&]/', $password)) {
                    $passwordErrors[] = 'Password must contain at least one special character (@$!%*?&).';
                }
                
                // Add password errors to the session
                if (!empty($passwordErrors)) {
                    session()->flash('password_errors', $passwordErrors);
                }
                
                // Add other validation errors
                foreach ($errors->all() as $error) {
                    Toastr::error($error, 'Validation Error');
                }
                
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            
            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();
            
            // Sanitize inputs
            $name = filter_var($request->name, FILTER_SANITIZE_STRING);
            $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
            $role_name = filter_var($request->role_name, FILTER_SANITIZE_STRING);
            
            $user = new User;
            $user->name         = $name;
            $user->email        = $email;
            $user->role_name    = $role_name;
            $user->password     = Hash::make($request->password);
            $user->join_date    = $todayDate;
            $user->status       = 'Active';
            $user->avatar       = 'photo_defaults.jpg';
            $user->save();

            DB::commit();
            Toastr::success('Account created successfully! You can now login.','Success');
            return redirect()->route('login');
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Registration failed: ' . $e->getMessage(),'Error');
            return redirect()->back();
        }
    }
}
