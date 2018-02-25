<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function __construct()
    {
        $this->middleware('guest:admin',['except' => ['logout']]);
    }

    public function showLoginForm(){
         return view('auth.admin_login');
    }

    public function adminLogin(Request $request){
        // validate data
        $this->validate($request,[
            'email'    => 'required|email',
            'password' => 'required|min:3'
            ]);

        // attempt to log the user in
        if(Auth::guard('admin')->attempt(['email' => $request->email,'password' => $request->password], $request->remember)){
            // if successfull then redirect to specific location
            return redirect()->intended(route('admin.home'));
        }

        // if unsuccessfull then redirect to login form with form data
        return redirect()->back()->withInput($request->only('email','remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
