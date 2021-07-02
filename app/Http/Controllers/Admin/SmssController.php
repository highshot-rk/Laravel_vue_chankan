<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * SMS情報の画面のController
 */
class SmssController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $now   = Carbon::now();
        $year  = $now->year;
        $month = $now->month;
        return view('manage.smss.index', compact('users', 'year', 'month'));
    }
}
