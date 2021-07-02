<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 契約情報を扱うAPIのController
 */
class ContractsController extends ApiBaseController
{
    /**
     * 広告終了
     *
     * @param integer $id
     * @return json
     */
    public function fin($id)
    {
        \DB::transaction(function () use ($id) {
            $advertisement = Advertisement::find($id);
            $advertisement->status = config('const.advertisement.status.stop');
            $advertisement->save();
            $contract = $advertisement->contract;
            $contract->ended_at = Carbon::now();
            $contract->save();
        });
        return response()->noContent();
    }
}
