<?php

namespace App\Http\Controllers\Advertisement;

use App\Contract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContractConfirmRequest;
use App\Mail\EmailContractCompleteForManager;
use App\Mail\EmailContractCompleteForAdvertisement;

/**
 * (広告会社向け)契約情報の画面のController
 */
class ContractsController extends Controller
{
    /**
     * 契約最終確認
     *
     * @return view
     */
    public function confirm($token)
    {
        // トークン認証を行う
        $contract = Contract::where('token', $token)->firstOrFail();
        return view('manage.adsContract', compact('contract'));
    }

    /**
     * 契約最終確認の更新処理
     *
     * @return view
     */
    public function mainRegister(ContractConfirmRequest $request)
    {
        \DB::transaction(function () use ($request) {
            // 契約情報＆広告会社のステータスを更新
            $contract = Contract::where('token', $request->token)->firstOrFail();
            $now = Carbon::now();
            $contract->token             = null;
            $contract->started_at        = $now;
            $contract->approve_at        = $now;
            $contract->save();
            $contract->advertisement->status = config('const.advertisement.status.open');
            $contract->advertisement->save();
            // 管理者へメール送信
            $email   = new EmailContractCompleteForManager($contract, $contract->advertisement);
            $manager = $contract->advertisement->manager;
            Mail::to($manager->email)->send($email);
            // 広告会社へメール送信
            $email   = new EmailContractCompleteForAdvertisement($contract, $contract->advertisement);
            Mail::to($contract->advertisement->email)->send($email);
        });
        return view('manage.adsContractComplete');
    }

    /**
     * 契約完了
     *
     * @return view
     */
    public function complete()
    {
        return view('manage.adsContractComplete');
    }

}
