<?php

namespace App\Services;

use App\Sms;
use App\User;
use App\Charge;
use App\Project;
use App\Jobs\SendSms;
use App\ProjectOrderer;
use Nexmo\Laravel\Facade\Nexmo;

/**
 * ショートメッセージを扱うService
 */
class SmsService
{
    const SECOND_SEND_DELAY = 10;
    const THIRD_SEND_DELAY = 20;

    /**
     * 案件に紐づく元請け＆担当者へショートメッセージ送信
     *
     * @param integer project_id
     * @param integer type
     * @param string message
     * @return void
     */
    static public function sendToProjectOrdererAndCharge($project_id, $type)
    {
        // 案件情報、送信先の情報を取得
        $project        = Project::find($project_id);
        $user           = User::find($project->user_id);
        $charge         = Charge::find($project->charge_id);
        $projectOrderer = ProjectOrderer::find($project->project_orderer_id);

        // 担当者へ送信
        if ($project->is_send_to_charge) {
            $message =
$charge->name.' 様

作業開始のご連絡をさせていただきます。

案件名：'.$project->name.'
作業開始時刻：'.$project->started_at->format('H:i').'

【オススメ足場業者】
'.route('sponsor.index').'

'.$user->company;
            SendSms::dispatch($charge->phone, $message)->delay(now()->addSeconds(self::SECOND_SEND_DELAY));
        }

        // 元請けへ送信
        if (!blank($projectOrderer->phone)) {
            $message =
$project->projectOrderer->company.' 様

作業開始のご連絡をさせていただきます。

案件名：'.$project->name.'
作業開始時刻：'.$project->started_at->format('H:i').'

【オススメ足場業者】
'.route('sponsor.index').'

'.$user->company;
            SendSms::dispatch($projectOrderer->phone, $message)->delay(now()->addSeconds(self::THIRD_SEND_DELAY));
        }
        // 送信情報を登録
        Sms::create([
            'user_id'           => $user->id,
            'charge_id'         => $project->charge_id,
            'type'              => $type,
            'is_sent_to_user'   => 0,
            'is_sent_to_charge' => $project->is_send_to_charge,
        ]);
    }

    /**
     * 案件に紐づく元請け＆担当者へショートメッセージ送信（完了）
     *
     * @param integer project_id
     * @param integer type
     * @param string message
     * @return void
     */
    static public function sendFinToProjectOrdererAndCharge($project_id, $type)
    {
        // 案件情報、送信先の情報を取得
        $project        = Project::find($project_id);
        $user           = User::find($project->user_id);
        $charge         = Charge::find($project->charge_id);
        $projectOrderer = ProjectOrderer::find($project->project_orderer_id);

        // 担当者へ送信
        if ($project->is_send_to_charge) {
            $message =
$charge->name.' 様

作業終了のご連絡をさせていただきます。

案件名：'.$project->name.'
作業終了時刻：'.$project->finished_at->format('H:i').'
作業終了内容：'.route('progress.fin', $project->id).'

【オススメ足場業者】
'.route('sponsor.index').'

'.$user->company;
            SendSms::dispatch($charge->phone, $message)->delay(now()->addSeconds(self::SECOND_SEND_DELAY));
        }

        // 元請けへ送信
        if (!blank($projectOrderer->phone)) {
            $message =
$project->projectOrderer->company.' 様

作業終了のご連絡をさせていただきます。

案件名：'.$project->name.'
作業終了時刻：'.$project->finished_at->format('H:i').'
作業終了内容：'.route('progress.fin', $project->id).'

【オススメ足場業者】
'.route('sponsor.index').'

'.$user->company;
            SendSms::dispatch($projectOrderer->phone, $message)->delay(now()->addSeconds(self::THIRD_SEND_DELAY));
        }
        // 送信情報を登録
        Sms::create([
            'user_id'           => $user->id,
            'charge_id'         => $project->charge_id,
            'type'              => $type,
            'is_sent_to_user'   => 0,
            'is_sent_to_charge' => $project->is_send_to_charge,
        ]);
    }

    /**
     * 案件に紐づく元請けへショートメッセージ送信
     *
     * @param integer project_id
     * @param integer type
     * @param string message
     * @return void
     */
    static public function sendToProjectOrderer($project_id, $type, $message)
    {
        // 案件情報、送信先の情報を取得
        $project        = Project::find($project_id);
        $user           = User::find($project->user_id);
        $charge         = Charge::find($project->charge_id);
        $projectOrderer = ProjectOrderer::find($project->project_orderer_id);
        // 元請けへ送信
        if (!blank($projectOrderer->phone)) {
            SendSms::dispatch($projectOrderer->phone, $message);
        }
        // 送信情報を登録
        Sms::create([
            'user_id'           => $user->id,
            'charge_id'         => $project->charge_id,
            'type'              => $type,
            'is_sent_to_user'   => 0,
            'is_sent_to_charge' => $project->is_send_to_charge,
        ]);
    }

    /**
     *
     * 担当者へログイン情報をショートメッセージ送信
     *
     * @param integer project_id
     * @param integer type
     * @param string message
     * @return void
     *
     */
    static public function sendToCharge($charge_id, $type, $message)
    {
        // 対象の担当者情報を取得する
        $charge = Charge::find($charge_id);

        // 担当者へSMS送信
        SendSms::dispatch($charge->phone, $message);

        // 送信情報を登録
        Sms::create([
            'user_id'           => $charge->user_id,
            'charge_id'         => $charge->id,
            'type'              => $type,
            'is_sent_to_user'   => 0,
            'is_sent_to_charge' => 1,
        ]);
    }

    /**
     * 案件に紐づくユーザー＆元請けへショートメッセージ送信
     * MEMO: 未使用となる
     *
     * @param integer project_id
     * @param integer type
     * @param string message
     * @return void
     */
    static public function sendToUserAndProjectOrderer($project_id, $type, $message)
    {
        // 案件情報、送信先の情報を取得
        $project        = Project::find($project_id);
        $user           = User::find($project->user_id);
        $charge         = Charge::find($project->charge_id);
        $projectOrderer = ProjectOrderer::find($project->project_orderer_id);
        // ユーザーへ送信
        if ($project->is_send_to_user) {
            // self::send($user->phone, $message);
            SendSms::dispatch($user->phone, $message);
        }

        // 担当者へ送信
        // self::send($charge->phone, $message);
        SendSms::dispatch($charge->phone, $message)->delay(now()->addSeconds(self::SECOND_SEND_DELAY));

        // 元請けへ送信
        if (!blank($projectOrderer->phone)) {
            // self::send($projectOrderer->phone, $message);
            SendSms::dispatch($projectOrderer->phone, $message)->delay(now()->addSeconds(self::THIRD_SEND_DELAY));
        }
        // 送信情報を登録
        Sms::create([
            'user_id'           => $user->id,
            'charge_id'         => $project->charge_id,
            'type'              => $type,
            'is_sent_to_user'   => 0,
            'is_sent_to_charge' => $project->is_send_to_charge,
        ]);
    }

    /**
     * ショートメッセージ送信
     *
     * @param string phone
     * @param string message
     * @return void
     */
    // static private function send($phone, $message)
    // {
    //     $phoneJpn = ltrim($phone, "0");
    //     $phoneJpn = "81" . $phoneJpn;
    //     // メッセージを送信
    //     Nexmo::message()->send([
    //         'to' => $phoneJpn,
    //         'from' => 'CATTOBI',
    //         'text' => $message,
    //         'type' => 'unicode'
    //     ]);
    // }
}
