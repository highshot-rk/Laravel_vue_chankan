<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Charge;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationForUser;
use App\Http\Resources\UserDetailResource;
use App\Http\Requests\Manage\UserEditRequest;
use App\Http\Requests\Manage\UserRegisterRequest;

/**
 * ユーザー情報を扱うAPIのController
 */
class UsersController extends ApiBaseController
{
    /**
     * 一覧
     *
     * @param integer $id
     * @return json
     */
    public function index(Request $request)
    {
        return new UserResource(User::search($request->all())->get());
    }

    /**
     * 詳細
     *
     * @param integer $id
     * @return json
     */
    public function show($id)
    {
        return new UserDetailResource(User::withTrashed()->where('id', $id)->first());
    }

    /**
     * 登録
     *
     * @param UserRegisterRequest $request
     * @return json
     */
    public function store(UserRegisterRequest $request)
    {
        \DB::transaction(function () use ($request) {
            $params = $request->all();
            // 未認証の同メールアドレスのユーザーが存在する場合、レコードを削除
            $user = User::ofEmail($request->email)->ofEmailVerifiedAtIsNull()->first();
            if ($user) {
                $user->delete();
            }
            // ユーザーを登録
            $user   = new User;
            $user->fill($params['user']);
            $user->manager_id  = \Auth::guard('admin')->user()->id;
            $user->limit_login = count($params['charges']) + 1;
            $user->email_token = \Str::random(20);
            $user->save();
            $email = new EmailVerificationForUser($user->email_token, $user);
            // 担当者を登録
            foreach ($params['charges'] as $inputCharge) {
                $charge                   = new Charge;
                $charge->user_id          = $user->id;
                $charge->is_parent        = false;
                $charge->name             = $inputCharge['name'];
                $charge->phone            = $inputCharge['phone'];
                $charge->email            = $inputCharge['email'];
                $charge->edit_type        = $inputCharge['editType'];
                $charge->contract_price   = $inputCharge['contractPrice'];
                $charge->save();
            }
            // ユーザーのメールアドレスへメール送信
            Mail::to($user->email)->send($email);
        });
        return response()->noContent();
    }

    /**
     * 更新
     *
     * @param integer $id
     * @return json
     */
    public function update(UserEditRequest $request, $id)
    {
        $params = $request->all();
        // 復帰フラグが設定されている場合はリストア
        if (isset($params['revival'])) {
            $user = User::find($id);
            $user->is_active = true;
            $user->save();
        } else {
            \DB::transaction(function () use ($request, $id, $params) {
                $user   = User::find($id);
                // 削除対象の担当者が存在する場合、削除
                if (isset($params['deleted_charge_ids'])) {
                    $ids = $params['deleted_charge_ids'];
                    foreach ($ids as $id) {
                        Charge::destroy($id);
                    }
                }
                if (isset($params['charges'])) {
                    foreach ($params['charges'] as $inputCharge) {
                        // idが存在しない場合、担当者の追加とみなし、登録
                        if (!isset($inputCharge['id'])) {
                            $charge                 = new Charge;
                            $charge->user_id        = $user->id;
                            $charge->name           = $inputCharge['name'];
                            $charge->phone          = $inputCharge['phone'];
                            $charge->email          = $inputCharge['email'];
                            $charge->edit_type      = $inputCharge['edit_type'];
                            $charge->contract_price = $inputCharge['contract_price'];
                            $charge->save();
                        } else {
                            // idが存在する場合、既存の値を更新
                            $charge                 = Charge::find($inputCharge['id']);
                            $charge->name           = $inputCharge['name'];
                            $charge->phone          = $inputCharge['phone'];
                            $charge->email          = $inputCharge['email'];
                            $charge->edit_type      = $inputCharge['edit_type'];
                            $charge->contract_price = $inputCharge['contract_price'];
                            $charge->save();
                        }
                    }
                    $user->prefecture_id = $params['user']['prefecture']['id'];
                    $user->enable_sms    = $params['user']['enable_sms'];
                    $user->fill($params['user']);
                    $user->save();
                    // 会員のコピーである担当者の情報も更新する
                    $charge = Charge::where('user_id', $user->id)->first();
                    $charge->name  = $user->name;
                    $charge->phone = $user->phone;
                    $charge->save();
                }

            });
        }
        return response()->noContent();
    }

    /**
     * 削除(※実質削除はせず、有効フラグを落とす)
     *
     * @param integer $id
     * @return json
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->is_active = false;
        $user->save();
        return response()->noContent();
    }
}
