<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar;
class CalendarController extends Controller
{
  public function index(Request $request)
  {
    $cal = new Calendar();
    $tag = $cal->showCalendarTag($request->month,$request->year);

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