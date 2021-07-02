<?php

namespace App\Http\Controllers\Admin;

use App\Contract;
use Carbon\Carbon;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContractRequest;
use App\Mail\EmailVerificationForAdvertisement;

/**
 * (管理者向け)広告会社の契約情報の画面のController
 */
class ContractsController extends Controller
{
    public function add($id)
    {
        return view('manage.adsContractRegister', compact('id'));
    }

    public function register(ContractRequest $request, $id)
    {
        $advertisement = Advertisement::find($id);
        ContractService::createAndSendMail($advertisement, $request->all());
        return view('manage.adsSubmitComplete', compact('id'));
    }

    public function submitComplete($id)
    {
        return view('manage.adsSubmitComplete', compact('id'));
    }

    public function complete()
    {
        return view('manage.adsRegisterComplete');
    }
}
