<?php

namespace App\Http\Controllers\Api;

use App\Prefecture;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrefectureResource;

/**
 * 都道府県の情報を扱うAPIのController
 */
class PrefecturesController extends ApiBaseController
{
    /**
     * 一覧取得
     *
     * @return json
     */
    public function index()
    {
        return new PrefectureResource(Prefecture::all());
    }
}