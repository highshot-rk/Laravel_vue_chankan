<?php

namespace App\Http\Controllers\Api;

use App\Contract;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Http\Resources\AdvertisementResource;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\AdvertisementEditRequest;
use App\Http\Requests\AdvertisementStoreRequest;
use App\Http\Resources\AdvertisementDetailResource;

/**
 * 広告会社の情報を扱うAPIのController
 */
class AdvertisementsController extends ApiBaseController
{
    public function index(Request $request)
    {
        return new AdvertisementResource(Advertisement::search($request->all())->get());
    }

    public function show($id)
    {
        return new AdvertisementDetailResource(Advertisement::find($id));
    }

    /**
     * 登録
     *
     * @param AdvertisementStoreRequest $request
     * @return json
     */
    public function store(AdvertisementStoreRequest $request)
    {
        \DB::transaction(function () use ($request) {
            // 広告会社を登録する
            $advertisement       = new Advertisement;
            $params              = $request->all();
            $advertisementParams = $params['advertisement'];
            $contractParams      = $params['contract'];
            $advertisement->fill($advertisementParams);
            // 広告画像を保存する
            if ($request->hasFile('image')) {
                $advertisement->img_url = $request->image->store('/img/advertisements');
            }
            $advertisement->manager_id = \Auth::guard('admin')->user()->id;
            // $advertisement->status     = config('const.advertisement.status.open');
            $advertisement->save();
            // 契約を登録する＆広告会社へメール送信する
            ContractService::createAndSendMail($advertisement, $contractParams);
        });
        return response()->noContent();
    }

    /**
     * 更新
     *
     * @param AdvertisementEditRequest $request
     * @param integer $id
     * @return json
     */
    public function update(AdvertisementEditRequest $request, $id)
    {
        $advertisement = Advertisement::find($id);
        $params = $request->all();
        unset($params['contracts']);
        $advertisement->fill($params);
        $advertisement->save();
        return response()->noContent();
    }

    /**
     * 削除
     *
     * @param integer $id
     * @return json
     */
    public function destroy($id)
    {
        \DB::transaction(function () use ($id) {
            $advertisement = Advertisement::find($id);
            $advertisement->contracts()->delete();
            $advertisement->delete();
        });
        return response()->noContent();
    }
}
