<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Manager;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * (管理者向け)広告会社情報の画面のController
 */
class AdvertisementsController extends Controller
{
    public function index()
    {
        return view('manage.ads');
    }

    public function add()
    {
        return view('manage.adsRegister');
    }

    /**
     * 広告出稿仮登録完了
     *
     * @return view
     */
    public function submitComplete($id)
    {
        return view('manage.adsSubmitComplete', compact('id'));
    }

    /**
     * 広告会社_詳細
     *
     * @param integer $id
     * @return view
     */
    public function show($id)
    {
        return view('manage.adsDetail', compact('id'));
    }

    /**
     * 広告会社_編集
     *
     * @param integer $id
     * @return view
     */
    public function edit($id)
    {
        return view('manage.adsDetailEdit', compact('id'));
    }
}
