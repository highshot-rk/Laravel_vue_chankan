<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Project;
use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * (ユーザー向け)現地調査情報の画面のController
 */
class SurveysController extends Controller
{
    /**
     * 案件_調査報告登録画面へ遷移
     *
     * @return view
     */
    public function register($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        $project_id = $id;
        $enable_sms = $project->user->enable_sms;
        return view('survey.register', compact('project_id', 'enable_sms'));
    }

    /**
     * 案件_調査報告_完了画面へ遷移
     *
     * @return view
     */
    public function complete($id)
    {
        // 案件が自分自身のユーザーIDに紐づいていない場合、元ページへリダイレクト
        $project = Project::find($id);
        if ($project->user_id !== AuthService::getAuthUser()->id) {
            return redirect()->back();
        }
        $is_send_to_project_orderer = $project->is_send_to_project_orderer;
        return view('survey.complete', compact('id', 'is_send_to_project_orderer'));
    }

    /**
     * 案件_調査報告_URL
     *
     * @return view
     */
    public function show($id)
    {
        $survey     = Survey::find($id);
        $survey_id  = $id;
        $enable_sms = $survey->projectLabel->project->user->enable_sms;
        return view('survey.show', compact('survey_id', 'survey', 'enable_sms'));
    }
}
