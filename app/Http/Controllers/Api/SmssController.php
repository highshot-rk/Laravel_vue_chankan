<?php

namespace App\Http\Controllers\Api;

use App\Services\SmsService;
use App\Http\Requests\SmsRequest;

/**
 * ショートメッセージを扱うAPIのController
 */
class SmssController extends ApiBaseController
{
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

}
