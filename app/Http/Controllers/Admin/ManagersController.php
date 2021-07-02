<?php

namespace App\Http\Controllers\Admin;

use App\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailRegisterCompleteForManager;
use App\Http\Requests\ManagerEditRequest;
use App\Http\Requests\ManagerStoreRequest;

/**
 * 管理者情報の画面のController
 */
class ManagersController extends Controller
{
    public function index(Request $request)
    {
        $activeManagers  = Manager::ofIsActive(true)->get();
        $stoppedManagers = Manager::ofIsActive(false)->get();
        return view('manage.managers.index', compact('activeManagers', 'stoppedManagers'));
    }

    public function add()
    {
        return view('manage.managers.add');
    }

    public function edit($id)
    {
        $manager = Manager::find($id);
        return view('manage.managers.edit', compact('manager'));
    }

    public function register(ManagerStoreRequest $request)
    {
        Manager::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'owner'    => config('const.manager.manager'),
            'password' => Hash::make($request->password)
        ]);
        // 登録された管理者のメールアドレスへメール送信
        $email = new EmailRegisterCompleteForManager($request->email);
        Mail::to($request->email)->send($email);

        return redirect()->route('admin.managers.index')->with('message', '管理者[' . $request->name . ']を登録しました。');
    }

    public function update(ManagerEditRequest $request, $id)
    {
        $manager = Manager::find($id);
        $manager->fill([
            'name'  => $request->name,
            'email' => $request->email,
        ]);
        $manager->save();
        return redirect()->route('admin.managers.edit', $manager->id)->with('message', '管理者[' . $request->name . ']の情報を更新しました。');
    }
}
