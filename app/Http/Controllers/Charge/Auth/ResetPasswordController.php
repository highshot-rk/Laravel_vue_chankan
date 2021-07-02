<?php

namespace App\Http\Controllers\Charge\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/charge/calendar';

    /**
     * パスワードリセットの間、使用されるガードの取得
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard('charge');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('charge.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function broker()
    {
        return \Password::broker('charges');
    }
}
