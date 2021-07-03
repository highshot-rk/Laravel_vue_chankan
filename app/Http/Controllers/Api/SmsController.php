<?php

namespace App\Http\Controllers\Api;

use App\Sms;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\SmsRequest;
use App\Http\Resources\SmsResource;

/**
 * ショートメッセージを扱うAPIのController
 */
class SmsController extends ApiBaseController
{
    /**
     * 年月に対応する金額取得
     *
     * @param Request $request
     * @return json
     */
    public function getCountAndPrice(Request $request)
    {
        $user_id = AuthService::getAuthUser()->id;
        return new SmsResource(Sms::search($request->all(), $user_id)->get());
    }

    /**
     * ショートメッセージ送信：(ユーザー)現場調査報告時
     *
     * @param Request $request
     * @return json
     */
    public function sendSurvey(SmsRequest $request)
    {
        $type = config('const.sms.type.survey');
        SmsService::sendToUserAndProjectOrderer($request->project_id, $type, $request->message);
        return response()->noContent();
    }

    /**
     * ショートメッセージ送信：(ユーザー)前日連絡時
     *
     * @param Request $request
     * @return json
     */
    public function sendAdvanceNotice(SmsRequest $request)
    {
        $type = config('const.sms.type.advance_notice');
        SmsService::sendToUserAndProjectOrderer($request->project_id, $type, $request->message);
        return response()->noContent();
    }

    /**
     * ショートメッセージ送信：(担当者)ログイン
     *
     * @param Request $request
     * @return json
     */
    public function sendChargeLogin(SmsRequest $request)
    {
        $type = config('const.sms.type.charge_login');
        SmsService::sendToCharge($request->project_id, $type, $request->message);
        return response()->noContent();
    }

    /**
     * ショートメッセージ送信：(クライアント)作業開始
     *
     * @param Request $request
     * @return json
     */
    public function sendStart(SmsRequest $request)
    {
        $type = config('const.sms.type.start');
        SmsService::sendToUserAndProjectOrderer($request->project_id, $type, $request->message);
        return response()->noContent();
    }

    /**
     * ショートメッセージ送信：(クライアント)作業完了
     *
     * @param Request $request
     * @return json
     */
    public function sendFin(SmsRequest $request)
    {
        $type = config('const.sms.type.fin');
        SmsService::sendToUserAndProjectOrderer($request->project_id, $type, $request->message);
        return response()->noContent();
    }
}
