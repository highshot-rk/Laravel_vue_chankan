<?php

namespace App\Http\Controllers\Api;

use App\Manager;
use Illuminate\Http\Request;
use App\Http\Resources\ManagerResource;
use App\Http\Controllers\Api\ApiBaseController;

/**
 * 管理者情報を扱うAPIのController
 */
class ManagersController extends ApiBaseController
{
    /**
     * 一覧を取得する
     *
     * @return json
     */
    public function index()
    {
        return (new ManagerResource(Manager::all()));
    }

    /**
     * 稼働中/停止中を更新する
     *
     * @param Request $request
     * @return json
     */
    public function updateIsActive(Request $request, $id)
    {
        $manager = Manager::find($id);
        $manager->is_active = $request->is_active;
        $manager->save();
        return response()->noContent();
    }
}
