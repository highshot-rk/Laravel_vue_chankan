<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\ChargeRemark;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChargeRemarkRequest;
use App\Http\Resources\ChargeRemarkResource;

class ChargeRemarksController extends ApiBaseController
{
    // メモ一覧表示
    public function index(Request $request)
    {
        return new ChargeRemarkResource(ChargeRemark::search($request->all())->get());
    }

    // メモ詳細表示
    public function show($id)
    {
        return new ChargeRemarkResource(ChargeRemark::find($id));
    }

    // メモ保存
    public function store(ChargeRemarkRequest $request)
    {
        $chargeRemark = new ChargeRemark();
        $charegeId = $request->worker_id;
        if (empty($charegeId)) {
            $charegeId = 0;
        }

        // メモの情報を保存する
        $chargeRemark->fill([
            'user_id'   => AuthService::getAuthUser()->id,  // ユーザーID
            'charge_id' => $charegeId,   // 担当者
            'work_on'   => $request->work_on,     // 日付
            'time_type' => $request->time_type,   // AM・PM・未定
            'remarks'   => $request->remarks      // メモ内容
        ])->save();
        // IDをVueファイルにレスポンス
        return response()->json(['id' => $chargeRemark->id]);
    }

    // メモ更新
    // public function update(ChargeRemarkRequest $request, $id)
    // {
    //     (ChargeRemarkRequest::findOrFail($id))->fill($request->all())->save();
    public function update(Request $request, $id)
    {
        (ChargeRemark::findOrFail($id))->fill($request->all())->save();
        return response()->noContent();
        // IDをVueファイルにレスポンス
        // return response()->json(['id' => $chargeRemark->id]);
    }

    // メモ削除
    public function destroy(ChargeRemark $chargeRemark)
    {
        $chargeRemark->delete();
        return response()->noContent();
    }

    /**
     * 複数のメモを削除する
     *
     * @param Request $request
     * @return json
     */
    public function destroyByMultiId(Request $request)
    {
        $chargeRemarks = ChargeRemark::whereIn('id', $request->ids)->delete();
        return response()->noContent();
    }
}
