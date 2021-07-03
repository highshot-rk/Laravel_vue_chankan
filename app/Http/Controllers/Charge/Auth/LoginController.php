<?php

namespace App\Http\Controllers\Charge\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/charge/calendar';


    /**
     * ログインIDを電話番号に変更
     *
     * @return void
     */
    public function username() {
        return 'phone';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:charge')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function credentials(Request $request)
    {
        $request->merge(['is_parent' => 0]);
        return $request->only($this->username(), 'password', 'is_parent');
    }

    // ログイン画面
    public function showLoginForm()
    {
        return view('charges.auth.login');
    }

    protected function guard()
    {
        return \Auth::guard('charge'); // 担当者認証のguardを指定
    }

    /**
     * ログイン試行処理
     *
     * @param Request $request
     * @return void
     */
    protected function attemptLogin(Request $request)
    {
        $result = $this->guard()->attempt($this->credentials($request), $request->filled('remember'));
        return $result;
    }

    // ログアウト
    public function logout(Request $request)
    {
        \Auth::guard('charge')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/charge-login'); // ログアウト後のリダイレクト先
    }

}
