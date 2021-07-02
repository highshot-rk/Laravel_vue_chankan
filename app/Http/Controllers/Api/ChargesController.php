<?php

namespace App\Http\Controllers\Api;

use App\Charge;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Resources\ChargeResource;
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
    public function index(Request $request)
    {
        $user_id = AuthService::getAuthUser()->id;
        return new ChargeResource(Charge::search($request->all(), $user_id)->get());
    }


    // /**
    //  * ソート順更新
    //  *
    //  * @param ProjectRequest $request
    //  * @param integer $id
    //  * @return json
    //  */
    // public function updateSort(Request $request, $id)
    // {
    //     $charge = Charge::find($id);
    //     $beforeSort = $charge->sort;
    //     $afterSort = $request->sort;

    //     // 移動元～移動先のソート番号に該当するレコードを全件取得する
    //     $charges = null;

    //     if ($afterSort < $beforeSort) {
    //         // 移動元の方が大きければ、全件ソート番号をインクリメント
    //         $charges = Charge::whereBetween('sort', [$afterSort, $beforeSort]);
    //         $charges->increment('sort');
    //     } elseif ($afterSort > $beforeSort) {
    //         // 移動先の方が大きければ、全件ソート番号をデクリメント
    //         $charges = Charge::whereBetween('sort', [$beforeSort, $afterSort]);
    //         $charges->decrement('sort');
    //     }

    //     // 移動元のソート番号を移動先ソート番号に更新する
    //     $charge->sort = $afterSort;
    //     $charge->save();

    //     return response()->noContent();
    // }
}
