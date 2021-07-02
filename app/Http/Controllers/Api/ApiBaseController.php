<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * 各APIのControllerの、基底クラス
 */
class ApiBaseController extends Controller
{
    public function __construct()
    {
        // TODO:実装がある程度完了後、コメントアウトを除外し、ユーザー認可を有効にする
        // $this->middleware('auth:api');
    }
}
