<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * (ユーザー向け)案件情報の画面のController
 */
class TermsController extends Controller
{
    /**
     * 案件情報登録画面へ遷移
     *
     * @return view
     */
    public function service()
    {
        return view('terms.service');
    }
    public function privacy()
    {
        return view('terms.privacy');
    }
}