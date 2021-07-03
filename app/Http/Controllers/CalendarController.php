<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar;
use Illuminate\Support\Facades\Auth;
class CalendarController extends Controller
{
    public function index(Request $request)
    {
        // ステータスを取得
        $status = Auth::user()->is_active;
        if($status === 0) {
            Auth::logout();
            $error = '管理者にアカウントを停止させられています。管理者に連絡してください。';
            return redirect()->route('login')->withErrors($error);
        }
        $cal = new Calendar();
        $tag = $cal->showCalendarTag($request->month, $request->year);

        return view('calendar.index', ['cal_tag' => $tag]);
    }
}



// namespace App\Http\Controllers;

// use App\Charge;
// use Illuminate\Http\Request;

// /**
//  * (ユーザー向け)カレンダー画面のController
//  */
// class CalendarController extends Controller
// {
//     /**
//      * カレンダー画面へ遷移
//      *
//      * @return view
//      */
//     public function index()
//     {
//         return view('calendar.index');
//     }
// }
