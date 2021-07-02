<?php

namespace App\Http\Controllers;

use App\User;
use App\Charge;
use Carbon\Carbon;
use App\Prefecture;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailCompleteForUser;
use App\Mail\EmailCompleteForCharge;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserMainRegisterRequest;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * (ユーザー向け)ユーザー情報の画面のController
 */
class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/calendar';

    /**
     * ユーザー情報画面へ遷移
     *
     * @return void
     */
    public function show() {
        $user = AuthService::getAuthUser();
        return view('user.index', compact('user'));
    }

    /**
     * ユーザー情報_編集画面へ遷移
     *
     * @return void
     */
    public function edit() {
        $user = AuthService::getAuthUser();
        foreach ($user->charges as $index => $charge) {
            // is_parentがTrueの担当者は=会員なので、担当者の項目には表示させない様、配列から削除する。
            if ($charge->is_parent) {
                unset($user->charges[$index]);
                break;
            }
        }
        $prefectures = Prefecture::all();
        return view('user.edit', compact('user', 'prefectures'));
    }

    /**
     * ユーザー情報_更新処理
     *
     * @return void
     */
    public function update(UserEditRequest $request) {
        if (\Auth::guard('charge')->check()) {
            // 担当者でログインしている場合の処理
            \Auth::guard('charge')->user()->fill($request->all())->save();
        } else {
            // ユーザーでログインしている場合の処理
            \DB::transaction(function () use ($request) {
                $user    = AuthService::getAuthUser();
                $charges = $request->charge;
                $params  = $request->all();
                unset($params['charge']);
                $user->fill($params);
                foreach ($charges as $charge) {
                    $userCharge = Charge::find($charge['id']);
                    $userCharge->fill($charge)->save();
                }
                $user->save();
                // 会員でログインしている場合、担当者の情報も更新する
                $charge = Charge::where('user_id', $user->id)->first();
                $charge->name = $user->name;
                $charge->email = $user->email;
                $charge->phone = $user->phone;
                $charge->save();
            });
        }
        if (\Auth::guard('charge')->check()) {
            return redirect()->route('charge.user.edit')->with('message', 'ユーザー情報を更新しました。');
        }
        return redirect()->route('user.edit')->with('message', 'ユーザー情報を更新しました。');
    }

    /**
     * ユーザー情報_パスワード更新処理
     *
     * @return void
     */
    public function updatePassword(UserPasswordRequest $request) {
        if (\Auth::guard('charge')->check()) {
            // 担当者でログインしている場合の処理
            $charge = \Auth::guard('charge')->user();
            $charge->password = Hash::make($request->password);
            $charge->save();
        } else {
            // ユーザーでログインしている場合の処理
            $user = AuthService::getAuthUser();
            $user->password = Hash::make($request->password);
            $user->save();
        }
        if (\Auth::guard('charge')->check()) {
            return redirect()->route('charge.user.edit')->with('message', 'パスワードを更新しました。');
        }
        return redirect()->route('user.edit')->with('message', 'パスワードを更新しました。');
    }

    /**
     * ユーザー情報_編集_パスワード画面へ遷移
     *
     * @return void
     */
    public function editPassword() {
        return view('user.editPassword');
    }

    /**
     * 基本項目入力画面へ遷移
     *
     * @return void
     */
    public function register($token) {
        // トークン認証を行う
        $user        = User::withoutGlobalScope('email_verified_at')->where('email_token', $token)->firstOrFail();
        $prefectures = Prefecture::all();
        $email       = $user->email;
        $time1 = Carbon::now();
        $time2 = new Carbon($user->created_at);
        /* 登録日時から1時間経過している場合：
        ・DBよりユーザー情報＆担当者情報を削除する
        ・リダイレクトする */
        if ($time1->gt($time2->addHour())) {
            \DB::transaction(function () use ($user) {
                $user->charges()->forceDelete();
                $user->forceDelete();
            });
            return redirect(config('const.landing_page.url'));
        }
        return view('enter-information.index', compact('token', 'email', 'user', 'prefectures'));
    }

    /**
     * ユーザー登録処理
     *
     * @return void
     */
    public function mainRegister(UserMainRegisterRequest $request) {
        $user = User::withoutGlobalScope('email_verified_at')->where('email_token', $request->token)->firstOrFail();
        \DB::transaction(function () use ($request, $user) {
         // トークンからユーザー情報を取得
            $chargesValue = $request->charges;
            $params       = $request->all();
            unset($params['charges']);
            $user->fill($params);
            $user->password          = Hash::make($request->password);
            $user->email_verified_at = Carbon::now();
            $user->email_token       = null;
            $user->save();
            // 担当者として会員を登録
            $charge                   = new Charge;
            $charge->user_id          = $user->id;
            $charge->is_parent        = true;
            $charge->name             = $user->name;
            $charge->phone            = $user->phone;
            $charge->email            = $user->email;
            $charge->edit_type        = config('const.charge.edit_type.edit');
            $charge->contract_price   = 0;
            $charge->save();

            if ($chargesValue != Null) {
                foreach ($chargesValue as $chargeValue) {
                    $charge = Charge::find($chargeValue['id']);
                    $charge->fill($chargeValue);
                    $charge->password = \Hash::make($chargeValue['password']);
                    $charge->save();
                    // 担当者のメールアドレスへメール送信
                    $email = new EmailCompleteForCharge($charge, $chargeValue['password']);
                    Mail::to($charge->email)->send($email);
                }
            }
            // ユーザーのメールアドレスへメール送信
            $email = new EmailCompleteForUser($user, $request->password);
            Mail::to($user->email)->send($email);
        });


        $this->guard()->login($user);
        return redirect()->route('calendar');
    }
}
