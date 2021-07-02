<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * (ユーザー向け)未解体案件の画面のController
 */
class YetProjectsController extends Controller
{
    public function index()
    {
        $params     = [];
        $params['project_type'] = [config('const.project.type.undisassembled')];
        $user_id  = AuthService::getAuthUser()->id;
        $projects = Project::search($params, $user_id)->get();
        return view('calendar.undemolition', compact('projects'));
    }

    public function register($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        return view('calendar.undemolitionRegister', compact('id'));
    }
}
