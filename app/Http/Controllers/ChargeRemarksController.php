<?php

namespace App\Http\Controllers;

use App\ChargeRemark;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class ChargeRemarksController extends Controller
{
    // 一覧
    public function index (Request $request)
    {
        $params[] = '';
        $params['user_id'] = AuthService::getAuthUser()->id;
        if(isset($request['work_on'])) {
            $params['work_on_from'] = $request['work_on'];
        }
        $charge_remark = new ChargeRemark();
        $charge_remarks = $charge_remark->search($params)->orderBy('work_on', 'asc')->get();

        return view('charge-remarks.index', compact('charge_remarks'));
    }
    // 詳細
    public function show ()
    {
        return view('charge-remarks.show');
    }
}
