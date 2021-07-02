<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/clients';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    // ログイン画面
    public function showLoginForm()
    {
        return view('manage.auth.login'); // 管理者ログインページのテンプレート
    }

    protected function guard()
    {
        return \Auth::guard('admin'); // 管理者認証のguardを指定
    }

    // ログアウト
    public function logout(Request $request)
    {
        \Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/manage-login'); // ログアウト後のリダイレクト先
    }

    // managersのownerカラムの値により、ログイン後のリダイレクト先を分ける(guardを分ける)
    public function redirectTo() {
        $role = $this->guard()->user()->owner;
        if ($role === config('const.manager.manager')) {
            return '/admin/home';
        } else if ($role === config('const.manager.owner')) {
            return '/clients';
        }
        return '/';
    }
}
