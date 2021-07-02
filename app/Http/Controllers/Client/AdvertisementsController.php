<?php

namespace App\Http\Controllers\Client;

use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * (クライアント向け)広告会社情報の画面のController
 */
class AdvertisementsController extends Controller
{
    /**
     * 広告会社一覧画面
     *
     * @return view
     */
    public function index()
    {
        $advertisements = Advertisement::ofStatus(config('const.advertisement.status.open'))->inRandomOrder()->get();
        return view('sponsor.index', compact('advertisements'));
    }
}
