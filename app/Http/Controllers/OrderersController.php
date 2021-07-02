<?php

namespace App\Http\Controllers;

use App\ProjectOrderer;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\ProjectOrdererRequest;

/**
 * (ユーザー向け)元請け情報の画面のController
 */
class OrderersController extends Controller
{
    public function index()
    {
        $user_id = AuthService::getAuthUser()->id;
        $projectOrderers = ProjectOrderer::ofUserId($user_id)->get();
        return view('orderers.index', compact('projectOrderers'));
    }

    public function add()
    {
        return view('orderers.add');
    }

    public function show($id)
    {
        // 元請けが自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $projectOrderer = ProjectOrderer::find($id);
        if ($projectOrderer->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        return view('orderers.detail', compact('id'));
    }

    public function edit($id)
    {
        $projectOrderer = ProjectOrderer::find($id);
        // 元請けが自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        if ($projectOrderer->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        $zip_first      = substr($projectOrderer->zip, 0, 3);
        $zip_second     = substr($projectOrderer->zip, 3, 4);
        return view('orderers.edit', compact('projectOrderer', 'zip_first', 'zip_second'));
    }

    public function store(ProjectOrdererRequest $request)
    {
        $projectOrderer          = new ProjectOrderer;
        $projectOrderer->zip     = $request->zip_first . $request->zip_second;
        $projectOrderer->user_id = AuthService::getAuthUser()->id;
        $params                  = $request->all();
        unset($params['zip_first']);
        unset($params['zip_second']);
        $projectOrderer->fill($params);
        $projectOrderer->save();
        if (\Auth::guard('charge')->check()) {
            return redirect()->route('charge.orderers.show', $projectOrderer->id)->with('message', '元請け情報を登録しました。');
        }
        return redirect()->route('orderers.show', $projectOrderer->id)->with('message', '元請け情報を登録しました。');
    }

    public function update(ProjectOrdererRequest $request, $id)
    {
        $projectOrderer      = ProjectOrderer::find($id);
        $projectOrderer->zip = $request->zip_first . $request->zip_second;
        $params              = $request->all();
        unset($params['zip_first']);
        unset($params['zip_second']);
        $projectOrderer->fill($params);
        $projectOrderer->save();
        if (\Auth::guard('charge')->check()) {
            return redirect()->route('charge.orderers.edit', $projectOrderer->id)->with('message', '元請け情報を更新しました。');
        }
        return redirect()->route('orderers.edit', $projectOrderer->id)->with('message', '元請け情報を更新しました。');
    }
}
