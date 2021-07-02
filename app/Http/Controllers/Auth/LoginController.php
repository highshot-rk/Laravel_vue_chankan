<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Charge;
use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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
        // $this->middleware('guest')->except('logout');
    }

    /**
     * ログイン試行処理
     *
     * @param Request $request
     * @return void
     */
    protected function attemptLogin(Request $request)
    {
        // $result = \Auth::guard('web')->attempt($this->credentials($request), $request->filled('remember'));
        return \Auth::guard('web')->attempt($this->credentials($request), $request->filled('remember'));
        // if ($result) {
        //     return true;
        // }
        // return \Auth::guard('charge')->attempt($this->credentials($request), $request->filled('remember'));
    }

    protected function loggedOut(Request $request)
    {
        return redirect(route('login'));
    }

    public function redirectPath() {
        return '/calendar';
    }
}
