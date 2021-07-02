<?php

namespace App\Http\Controllers\Api;

use App\Survey;
use App\Project;
use Carbon\Carbon;
use App\SurveyImage;
use App\Services\SmsService;
use App\Http\Requests\SurveyRequest;
use App\Http\Resources\SurveyDetailResource;

class SurveysController extends ApiBaseController
{
    /**
     * 現地調査情報の詳細を取得
     *
     * @param SurveyRequest $request
     * @return void
     */
    public function store(SurveyRequest $request)
    {
        \DB::transaction(function () use ($request) {
            // 現地調査を登録
            $project               = Project::find($request->project_id);
            $project->is_surveyed  = 1;
            $project->surveyed_at  = Carbon::now();
            $project->save();
            $survey                = new Survey;
            $survey->is_send_to_project_orderer = $request->is_send_to_project_orderer == "true" ? true : false;
            $survey->remark        = $request->remark !== "null" ? $request->remark : null;
            $survey->url           = '';
            $survey->project_label = $project->projectLabel->id;
            $survey->save();
            $survey->url           = '/progress/survey/' . $survey->id;
            $survey->save();

            $url = null;
            foreach ($request['images']['file'] as $index => $image) {
                // ファイルをアップロード
                $url                      = $image->store('/img/surveys');
                $surveyImage              = new SurveyImage;
                $surveyImage->img         = $url;
                $surveyImage->description = $request['descriptions'][$index] !== "null" ? $request['descriptions'][$index] : null;
                $surveyImage->survey_id   = $survey->id;
                $surveyImage->save();
            }
            // ショートメッセージを送信
            if ($project->user->enable_sms) {
                if ($request->is_send_to_project_orderer == "true") {
                    $type    = config('const.sms.type.survey');
                    $message =
$project->projectOrderer->company.' 様

現場調査報告となります。

案件名：'.$project->name.'
現場調査内容：'.route('progress.survey.show', $survey->id).'

【オススメ足場業者】
'.route('sponsor.index');
                    SmsService::sendToProjectOrderer($project->id, $type, $message);
                }
            }
        });
        return response()->noContent();
    }

    /**
     * 現地調査情報の詳細を更新
     *
     * @param SurveyRequest $request
     * @return void
     */
    public function update(SurveyRequest $request, $id)
    {
        \DB::transaction(function () use ($request, $id) {
            // 現地調査を登録
            $survey                             = Survey::find($id);
            $survey->is_send_to_project_orderer = $request['is_send_to_project_orderer'] == "true" ? true : false;
            $survey->remark                     = $request['remark'] !== "null" ? $request['remark'] : null;
            $survey->save();

            $url          = null;
            $image_ids    = $request['image_ids'];
            $descriptions = $request['descriptions'];
            $images       = $request['images'];
            $files        = $request['images']['file'];
            // ファイルが存在しない部分も含め、ループで更新処理を実装する
            foreach ($image_ids as $index => $image_id) {
                // 新規である場合(idが存在しない場合)、ファイルをアップロード＆レコードを新規登録
                if ($image_id === "null") {
                    if ($images['is_uploaded'][$index] === "true") {
                        $file                     = array_shift($files);
                        $url                      = $file->store('/img/surveys');
                        $surveyImage              = new SurveyImage;
                        $surveyImage->img         = $url;
                        $surveyImage->description = $descriptions[$index] !== "null" ? $descriptions[$index] : null;
                        $surveyImage->survey_id   = $survey->id;
                        $surveyImage->save();
                    }
                } else {
                    $isExisting = false;
                    // 削除対象である場合、スキップ
                    if ($request['deleted_survey_image_ids']) {
                        if (!in_array($image_id, $request['deleted_survey_image_ids'], true)) {
                            $isExisting = true;
                        }
                    } else {
                        $isExisting = true;
                    }
                    // 既存である場合、説明文のみ更新
                    if ($isExisting) {
                        $surveyImage = SurveyImage::find($image_id);
                        $surveyImage->description = $descriptions[$index] !== "null" ? $descriptions[$index] : null;
                        $surveyImage->save();
                    }
                }
            }
            // 削除対象の画像情報を削除する
            if ($request['deleted_survey_image_ids']) {
                foreach ($request['deleted_survey_image_ids'] as $index => $deleted_survey_image_id) {
                    $surveyImage = SurveyImage::find($deleted_survey_image_id);
                    \Storage::delete($surveyImage->img);
                    $surveyImage->delete();
                }
            }
            // ショートメッセージを送信
            if ($survey->projectLabel->project->user->enable_sms) {
                if ($request['is_send_to_project_orderer'] == "true") {
                    $type    = config('const.sms.type.survey');
                    $message =
$survey->projectLabel->project->projectOrderer->company.' 様

現場調査報告となります。

案件名：'.$survey->projectLabel->project->name.'
現場調査内容：'.route('progress.survey.show', $survey->id).'

【オススメ足場業者】
'.route('sponsor.index');
                    SmsService::sendToProjectOrderer($survey->projectLabel->project->id, $type, $message);
                }
            }
        });
        return response()->noContent();
    }

    /**
     * 現地調査情報の詳細を取得
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        return new SurveyDetailResource(Survey::find($id));
    }
}
