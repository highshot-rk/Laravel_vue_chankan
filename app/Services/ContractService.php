<?php

namespace App\Services;

use App\Contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationForAdvertisement;

/**
 * 広告会社の契約を扱うService
 */
class ContractService
{
    /**
     * Undocumented function
     *
     * @param Advertisement $advertisement 広告会社情報
     * @param array $params 契約情報として保存するパラメータ
     * @return void
     */
    static public function createAndSendMail($advertisement, $params)
    {
        $contract = new Contract;
        $contract->fill($params);
        $contract->advertisement_id  = $advertisement->id;
        $contract->token             = \Str::random(20);
        $contract->schedule_ended_at = (Carbon::now())->addMonths($contract->addingCount());
        $contract->save();
        // 広告会社へメールを送信する
        $email = new EmailVerificationForAdvertisement($contract->token, $advertisement);
        Mail::to($advertisement->email)->send($email);
    }
}
