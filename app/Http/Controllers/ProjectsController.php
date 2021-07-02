<?php

namespace App\Http\Controllers;

use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * (ユーザー向け)案件情報の画面のController
 */
class ProjectsController extends Controller
{
    /**
     * 案件情報登録画面へ遷移
     *
     * @return view
     */
    public function add(Request $request)
    {
        $user_id = AuthService::getAuthUser()->id;
        $work_on_y = $request->y;
        $work_on_m = $request->m;
        $work_on_d = $request->d;
        return view('projects.register', compact(
            'user_id',
            'work_on_y',
            'work_on_m',
            'work_on_d'
        ));
    }

    /**
     * カレンダー_日別画面へ遷移
     *
     * @return view
     */
    public function index(Request $request)
    {
        $work_on = $request->work_on;
        $user_id = AuthService::getAuthUser()->id;
        $workOn  = $work_on;
        return view('calendar.daily', compact('workOn'));
    }

    /**
     * 案件_詳細画面へ遷移
     *
     * @return view
     */
    public function show($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        return view('projects.show', compact('id'));
    }

    /**
     * 案件_編集画面へ遷移
     *
     * @return view
     */
    public function edit($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        return view('projects.edit', compact('id'));
    }

    /**
     * 案件_新規登録_完了画面へ遷移
     *
     * @return view
     */
    public function complete()
    {
        return view('projects.addComplete');
    }

    /**
     * 案件_前日連絡画面へ遷移
     *
     * @return view
     */
    public function advanceNoticeShow($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        return view('projects.advancenotice', compact('id'));
    }

    /**
     * 案件_前日連絡_完了画面へ遷移
     *
     * @return view
     */
    public function advanceNoticeComplete($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        $enable_sms = $project->user->enable_sms;
        return view('projects.advancenoticeSent', compact('id', 'enable_sms'));
    }
}
