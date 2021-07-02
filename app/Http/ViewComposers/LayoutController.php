<?php

namespace App\Http\ViewComposers;

use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * 各ページ共通で使用するデータを定義
 */
class LayoutController
{
    public function compose(View $view)
    {
        $user            = null;
        $charges         = null;
        $charge          = null;
        $isCharge        = false;
        $isViewer        = false;
        $urlPrefix       = AuthService::getUrlPrefix();
        $projectOrderers = null;
        $priceThisMonth  = null;
        $pricePrevMonth  = null;
        $countThisMonth  = null;
        $countPrevMonth  = null;

        // ログイン中の場合、各情報を取得
        if (\Auth::guard('web')->check() || \Auth::guard('charge')->check()) {
            if (\Auth::guard('web')->check()) {
                $user = \Auth::user();
            } elseif (\Auth::guard('charge')->check()) {
                $charge   = \Auth::guard('charge')->user();
                $user     = $charge->user;
                $isCharge = true;
                if ($charge->edit_type == config('const.charge.edit_type.view')) {
                    $isViewer = true;
                }
            }
            $charges         = $user->charges;
            $projectOrderers = $user->projectOrderers;
            $now             = Carbon::now();
            $thisYear        = $now->year;
            $thisMonth       = $now->month;
            $prev            = $now->subMonth();
            $prevYear        = $prev->year;
            $prevMonth       = $prev->month;
            $priceThisMonth  = $user->smssPrice($thisYear, $thisMonth);
            $pricePrevMonth  = $user->smssPrice($prevYear, $prevMonth);
            $countThisMonth  = $user->smssCount($thisYear, $thisMonth);
            $countPrevMonth  = $user->smssCount($prevYear, $prevMonth);
        }
        $view->with([
            'loginUser'       => $user,
            'loginCharge'     => $charge,
            'charges'         => $charges,
            'isCharge'        => $isCharge,
            'isViewer'        => $isViewer,
            'urlPrefix'       => $urlPrefix,
            'projectOrderers' => $projectOrderers,
            'priceThisMonth'  => $priceThisMonth,
            'pricePrevMonth'  => $pricePrevMonth,
            'countThisMonth'  => $countThisMonth,
            'countPrevMonth'  => $countPrevMonth,
        ]);
    }
}
