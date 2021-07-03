<?php

namespace App\Http\Controllers\Client;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * (クライアント向け)案件情報の画面のController
 */
class ProjectsController extends Controller
{
    /**
     * 案件画面
     *
     * @param integer $id
     * @return void
     */
    public function show($id, Request $request)
    {
        $isOpen = $request->is_open ? $request->is_open : 'blank';
        // 案件のステータス取得
        $projectInstance = new Project;
        $project = $projectInstance->where('id', $id)->first();

        // レポート確認
        $isFinishedReported = false;
        if (isset($request->is_finish_reported)) {
            $isFinishedReported = true;
        }
        if($project['is_finished'] === 0) {
            return view('progress.index', compact('id', 'isOpen'));
        } elseif($project['is_finished'] === 1) {
            return view('progress.none', compact('id', 'project', 'isFinishedReported'));
        }
    }

    /**
     * 案件完了画面
     *
     * @param integer $id
     * @return void
     */
    public function report($id)
    {
        return view('progress.send', compact('id'));
    }

    /**
     * 案件完了送信画面
     *
     * @param integer $id
     * @return void
     */
    public function complete(Request $request, $id)
    {
        $isFinishedReported = false;
        $project = Project::find($id);
        if (isset($request->is_finish_reported)) {
            $isFinishedReported = true;
        }
        return view('progress.none', compact('id', 'project', 'isFinishedReported'));
    }

    /**
     * 案件報告画面
     *
     * @param integer $id
     * @return void
     */
    public function fin($id)
    {
        $project = Project::find($id);
        return view('progress.fin', compact('id', 'project'));
    }
}
