<?php

namespace App\Http\Controllers\Api;

use App\Charge;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Resources\ChargeResource;
use App\Http\Resources\ChargeDetailResource;
use App\Http\Controllers\Api\ApiBaseController;

/**
 * 担当者情報を扱うAPIのController
 */
class ChargesController extends ApiBaseController
{
    /**
     * 一覧取得
     *
     * @param Request $request
     * @return json
     */
    public function __construct()
    {
      
    }

    public function index(Request $request)
    {
        $user_id = AuthService::getAuthUser()->id;
        // return new ChargeResource(Charge::search($request->all(), $user_id)->get());
        $charges = Charge::where('user_id', $user_id)->orderBy('show_order', 'ASC')->get();
        return new ChargeResource($charges);
    }

    /**
     * 詳細
     *
     * @param integer $id
     * @return json
     */
    public function show($id)
    {
        return new ChargeDetailResource(Charge::find($id));
    }

    /**
     * 削除
     *
     * @param integer $id
     * @return json
     */
    public function destroy($id)
    {
        $user_id = AuthService::getAuthUser()->id;
        $charge = Charge::find($id);
        $charges = Charge::where('user_id', $user_id)->where('show_order', '>', $charge->show_order);
        $charges->decrement('show_order');
        Charge::destroy($id);
        return response()->noContent();
    }

    /**
     * ソート順更新
     *
     * @param ProjectRequest $request
     * @param integer $id
     * @return json
     */
    public function updateSort(Request $request, $id)
    {
        $charge = Charge::find($id);
        $beforeSort = $request->currentorder;
        if(!empty($charge)) {
            $beforeSort = $charge->show_order;
        }
        $afterSort = $request->sort;

        // 移動元～移動先のソート番号に該当するレコードを全件取得する
        $charges = null;
        $user_id = AuthService::getAuthUser()->id;
        if ($afterSort < $beforeSort) {
            // 移動元の方が大きければ、全件ソート番号をインクリメント
            $charges = Charge::where('user_id', $user_id)->whereBetween('show_order', [$afterSort, $beforeSort]);
            if (!empty($charges)) {
                $charges->increment('show_order');
            }
        } elseif ($afterSort > $beforeSort) {
            // 移動先の方が大きければ、全件ソート番号をデクリメント
            $charges = Charge::where('user_id', $user_id)->whereBetween('show_order', [$beforeSort, $afterSort]);
            if (!empty($charges)) {
                $charges->decrement('show_order');
            }
        }

        // 移動元のソート番号を移動先ソート番号に更新する
        if(!empty($charge)) {
            $charge->show_order = $afterSort;
            $charge->save();
        }

        return response()->noContent()->withHeaders([
            'Cache-Control' => 'no-store',
        ]);
    }
}
