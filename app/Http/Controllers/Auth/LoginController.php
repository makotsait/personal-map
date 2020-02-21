<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        $login_id = request()->input('login_id');
        $field = filter_var($login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
        // 利用中ユーザのみがログインできるようにする
        request()->merge([$field => $login_id, 'status' => 0]);
        return $field;
    }
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'status');
    }
    public function redirectPath()
    {
        return '/home';
    }

    public function userLogout()
    {
        Auth::logout();
        // return redirect()->route('user.signin');
    }
}
