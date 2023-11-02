<?php

namespace App\Http\Controllers\auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function login()
    {
        return view('auth.user.login');
    }

    public function loginUser(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // Attempt to log the user in
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $request->remember)) {

            return redirect()->route('user.dashboard');
        }
        // if unsuccessful, then redirect back to the login with the form data
        $errors = ['message' => 'Sorry! Wrong email or password'];
        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errors);
    }


    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect(route('user.login'));
    }
}
