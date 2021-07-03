<?php

namespace App\Http\Controllers\Api;

use App\Project;
use App\Charge;
use Carbon\Carbon;
use App\ProjectLabel;
use App\ProjectOrderer;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectFinishRequest;
use App\Http\Resources\ProjectDetailResource;

/**
 * 案件情報を扱うAPIのController
 */
class ProjectsController extends ApiBaseController
{
    /**
     * 一覧取得
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        // 対象のユーザーのIDを取得する
        $user_id = AuthService::getAuthUser()->id;
        return new ProjectResource(Project::search($request->all(), $user_id)->get());
        // $projects = Project::where('user_id', $user_id)->get();
        // return new ProjectResource($projects );
    }

    /**
     * 詳細取得
     *
     * @param $id
     * @return json
     */
    public function show($id)
    {
        return new ProjectDetailResource(Project::find($id));
    }

    /**
     * 案件更新
     *
     * @param ProjectRequest $request
     * @return json
     */
    public function update(Request $request, $id)
    {
        (Project::findOrFail($id))->fill($request->all())->save();
        return response()->noContent();
    }

    /**
     * 削除
     *
     * @param $id
     * @return json
     */
    public function destroy($id)
    {
        \DB::transaction(function () use ($id) {
            $project = Project::find($id);
            print("-------------------");
            // 案件ラベルに紐づく案件が未解体案件のみの場合、未解体案件と案件ラベルも削除する
            if (count($project->projectLabel->projects) === 1) {
                if ($project->projectLabel->project->project_type === config('const.project.type.undisassembled')) {
                    $project->projectLabel->project->delete();
                }
                $project->projectLabel->delete();
            } elseif ($project->project_type === config('const.project.type.erection')) {
                if (count($project->projectLabel->projects()->ofProjectType([config('const.project.type.erection')])->get()) === 1) {
                    // 同じラベルの案件内で他に架設案件がなければ、未解体案件と案件ラベルも同時に削除する
                    // $project->projectLabel->projects()->ofProjectType([config('const.project.type.undisassembled')])->delete();
                    $project->projectLabel->projects()->delete();
                    $project->projectLabel->delete();
                } else {
                    $project->projectLabel->projects()->delete();
                    $project->projectLabel->delete();
                }
            } elseif ($project->project_type === config('const.project.type.disassembled')) {
                // 同じラベルの案件内で他に案件がなければ、案件ラベルも同時に削除する
                if (count($project->projectLabel->projects()->get()) <= 1) {
                    $project->projectLabel->delete();
                } else {
                    // Project::where("name", $project->name)->where() $project
                    $project->projectLabel->projects()->delete();
                    $project->projectLabel->delete();
                }
            }
            $project->delete();
        });
        return response()->noContent();
    }

    /**
     * 登録
     *
     * @param ProjectRequest $request
     * @return json
     */
    public function store(ProjectRequest $request)
    {
        $projectId = \DB::transaction(function() use ($request) {
            $userId       = AuthService::getAuthUser()->id;
            $projectLabel = ProjectLabel::create();
            $id           = null;
            // 元請け情報を登録する
            if ($request->is_new_project_orderer) {
                // 元請け情報がテキストボックスにて入力されている場合：新規登録する
                $projectOrderer = ProjectOrderer::create(array_merge($request->project_orderer, ['user_id' => $userId]));
            } else {
                // 元請け情報がテキストボックスにて入力されていない場合：既存の情報から取得する
                $projectOrderer = ProjectOrderer::find($request->project_orderer_id);
            }
            // 架設案件を登録する
            $projectData = [];
            foreach ($request->project['work_on_date'] as $index => $workOn) {
                // 複数の配列をマージする
                $projectData = array_merge(
                    $request->project,
                    ['work_on'            => $workOn['work_on']],
                    ['time_type'          => $workOn['time_type']],
                    ['project_orderer_id' => $projectOrderer->id],
                    ['label'              => $projectLabel->id],
                    ['user_id'            => $userId],
                    ['project_type'       => config('const.project.type.erection')]
                );
                unset($projectData['work_on_date']);
                unset($projectData['enable_sms']);
                if ($index === 0) {
                    $id = Project::create($projectData)->id;
                } else {
                    Project::create($projectData);
                }
            }
            // 未解体案件を登録する
            unset($projectData['work_on']);
            unset($projectData['enable_sms']);
            $projectData['project_type'] = config('const.project.type.undisassembled');
            $projectData['time_type']    = config('const.project.time_type.none');
            Project::create($projectData);

            return $id;
        });
        return response()->json(['id' => $projectId]);
    }

    /**
     * 未解体案件更新
     *
     * @param ProjectRequest $request
     * @return json
     */
    public function updateUndisassembled(ProjectRequest $request, $id)
    {
        $projectId = \DB::transaction(function() use ($request, $id) {
            $project      = Project::find($id);
            $userId       = AuthService::getAuthUser()->id;
            $projectLabel = $project->projectLabel;
            $id           = null;
            // 未解体案件を削除する
            $project->delete();
            // 元請け情報を登録する
            if ($request->is_new_project_orderer) {
                // 元請け情報がテキストボックスにて入力されている場合：新規登録する
                $projectOrderer = ProjectOrderer::create(array_merge($request->project_orderer, ['user_id' => $userId]));
            } else {
                // 元請け情報がテキストボックスにて入力されていない場合：既存の情報から取得する
                $projectOrderer = ProjectOrderer::find($request->project_orderer_id);
            }
            // 解体案件を登録する
            $projectData = [];
            foreach ($request->project['work_on_date'] as $index => $workOn) {
                $projectData = array_merge(
                    $request->project,
                    ['work_on'            => $workOn['work_on']],
                    ['time_type'          => $workOn['time_type']],
                    ['project_orderer_id' => $projectOrderer->id],
                    ['label'              => $projectLabel->id],
                    ['user_id'            => $userId],
                    ['project_type'       => config('const.project.type.disassembled')]
                );
                unset($projectData['work_on_date']);
                unset($projectData['enable_sms']);
                if ($index === 0) {
                    $id = Project::create($projectData)->id;
                } else {
                    Project::create($projectData);
                }
            }
            return $id;
        });
        return response()->json(['id' => $projectId]);
    }

    /**
     * 架設・解体案件更新
     *
     * @param ProjectRequest $request
     * @param integer $id
     * @return json
     */
    public function updateErection(ProjectRequest $request, $id)
    {
        $projectId = $this->_updateProject($request, $id);
        return response()->json(['id' => $projectId]);
    }

    /**
     * LINE最終日時更新
     *
     * @param Request $request
     * @param integer $id
     * @return json
     */
    public function updateLineInfo(Request $request, $id)
    {
        $project = Project::find($id);
        $project->last_messaged_at = Carbon::now();
        $project->save();
        return response()->noContent();
    }

    /**
     * 備考更新
     *
     * @param ProjectRequest $request
     * @param integer $id
     * @return json
     */
    public function updateRemark(Request $request, $id)
    {
        $project = Project::find($id);
        $project->remark = $request->remark;
        $project->save();
        return response()->noContent();
    }

    /**
     * 前日連絡
     *
     * @param integer $id
     * @return json
     */
    public function advanceNotice(ProjectRequest $request, $id)
    {
        // 案件情報を更新
        $projectId = $this->_updateProject($request, $id);

        // 2テーブル以上の登録or更新がある為、トランザクションを張る
        \DB::transaction(function () use ($id) {
            // 案件情報のステータスを更新
            $project = Project::find($id);
            $project->is_notified = true;
            $project->notified_at = Carbon::now();
            $project->save();
            // ショートメッセージを送信
            if ($project->user->enable_sms == 1) {
                $type    = config('const.sms.type.advance_notice');
                $message =
$project->projectOrderer->company.' 様

前日連絡をさせていただきます。

案件名：'.$project->name.'
現場到着予定：'.$project->timeTypeName().' '.$project->scheduled_arrival_time_from.'〜'.$project->scheduled_arrival_time_to.'

【オススメ足場業者】
'.route('sponsor.index');
            SmsService::sendToProjectOrderer($id, $type, $message);
            }
        });
        return response()->noContent();
    }

    /**
     * 作業開始
     *
     * @param integer $id
     * @return json
     */
    public function start($id)
    {
        // 2テーブル以上の登録or更新がある為、トランザクションを張る
        \DB::transaction(function () use ($id)
        {
            // 案件情報のステータスを更新
            $project = Project::find($id);
            $project->is_started = true;
            $project->started_at = Carbon::now();
            $project->save();
            // 元請け：ショートメッセージを送信
            if ($project->user->enable_sms == 1) {
                $type    = config('const.sms.type.start');
                SmsService::sendToProjectOrdererAndCharge($id, $type);
            }
        });
        return response()->noContent();
    }

    /**
     * 作業完了
     *
     * @param integer $id
     * @return json
     */
    public function fin(ProjectFinishRequest $request, $id)
    {
        // 2テーブル以上の登録or更新がある為、トランザクションを張る
        \DB::transaction(function () use ($request, $id)
        {
            $url = null;
            // ファイルをアップロード
            // if ($request->hasFile('image')) {
            //     $url = $request->image->store('/public/img/projects');
            // }
            // 案件情報のステータスを更新
            $project = Project::find($id);
            // $project->finish_img = $url;
            if ($request->hasFile('image')) {
                $url = $request->image->store('/public/img/projects');
                $project->finish_img = str_replace("public", "storage", $url);
            }
            $project->is_finished = true;
            $project->finished_at = Carbon::now();
            $project->save();
            // ショートメッセージを送信
            if ($project->user->enable_sms == 1) {
                $type    = config('const.sms.type.fin');
                $message =
$project->projectOrderer->company.' 様

作業終了のご連絡をさせていただきます。

案件名：'.$project->name.'
作業終了時刻：'.$project->finished_at->format('H:i').'
作業終了内容：'.route('progress.fin', $project->id).'

【オススメ足場業者】
'.route('sponsor.index');
            SmsService::sendFinToProjectOrdererAndCharge($id, $type, $message);
            }
        });
        return response()->noContent();
    }

    /**
     * (案件更新メソッド、前日連絡メソッドより呼び出し)案件を更新する
     *
     * @param Request $request
     * @param integer $id
     * @return void
     */
    private function _updateProject(ProjectRequest $request, $id)
    {
        return \DB::transaction(function () use ($request, $id) {
            $originalProject = Project::find($id);
            $userId          = AuthService::getAuthUser()->id;
            $projectLabel    = $originalProject->projectLabel;
            $params = $request->all();
            // 元請け情報を登録する
            if ($request->is_new_project_orderer) {
                // 元請け情報がテキストボックスにて入力されている場合：新規登録する
                $projectOrderer = ProjectOrderer::create(array_merge($request->project_orderer, ['user_id' => $userId]));
            } else {
                // 元請け情報がテキストボックスにて入力されていない場合：既存の情報から取得する
                $projectOrderer = ProjectOrderer::find($request->project_orderer_id);
            }
            // 削除対象のプロジェクトが存在する場合、削除
            if (isset($params['deleted_project_ids'])) {
                $ids = $params['deleted_project_ids'];
                foreach ($ids as $id) {
                    Project::destroy($id);
                }
            }
            $projectData = [];
            foreach ($request->project['work_on_date'] as $index => $workOn) {
                // idが存在しない場合、施工予定日の追加とみなし、登録
                if (!isset($workOn['id'])) {
                    $project          = new Project;
                    $project->label   = $originalProject->label;
                    $projectData      = array_merge(
                        $request->project,
                        ['work_on'                     => $workOn['work_on']],
                        ['time_type'                   => $workOn['time_type']],
                        ['scheduled_arrival_time_from' => isset($workOn['scheduled_arrival_time_from']) ? $workOn['scheduled_arrival_time_from'] : null],
                        ['scheduled_arrival_time_to'   => isset($workOn['scheduled_arrival_time_to']) ? $workOn['scheduled_arrival_time_to'] : null],
                        ['project_orderer_id'          => $projectOrderer->id],
                        ['label'                       => $projectLabel->id],
                        ['user_id'                     => $userId],
                        ['project_type'                => $originalProject->project_type]
                    );
                    unset($projectData['work_on_date']);
                    unset($projectData['enable_sms']);
                    if ($index === 0) {
                        $id = Project::create($projectData)->id;
                    } else {
                        Project::create($projectData);
                    }
                } else {
                    // idが存在する場合、既存の値を更新
                    $project = Project::find($workOn['id']);
                    $projectData = array_merge(
                        $request->project,
                        ['work_on'                     => $workOn['work_on']],
                        ['time_type'                   => $workOn['time_type']],
                        ['scheduled_arrival_time_from' => $workOn['scheduled_arrival_time_from'] ? $workOn['scheduled_arrival_time_from'] : null],
                        ['scheduled_arrival_time_to'   => $workOn['scheduled_arrival_time_to'] ? $workOn['scheduled_arrival_time_to'] : null],
                        ['project_orderer_id'          => $projectOrderer->id],
                        ['label'                       => $projectLabel->id],
                        ['user_id'                     => $userId],
                        ['project_type'                => $originalProject->project_type]
                    );
                    unset($projectData['work_on_date']);
                    unset($projectData['enable_sms']);
                    $project->fill($projectData)->save();
                    if ($index === 0) {
                        $id = $project->id;
                    }
                }
            }
            // 更新対象のプロジェクトが架設案件である場合、未解体案件も更新する
            if ($originalProject->project_type === config('const.project.type.erection')) {
                $project = $originalProject->projectLabel->project()->ofProjectType([config('const.project.type.undisassembled')])->first();
                if ($project) {
                    $projectData = array_merge(
                        $request->project,
                        ['work_on'            => null],
                        ['time_type'          => config('const.project.time_type.none')],
                        ['project_orderer_id' => $projectOrderer->id],
                        ['label'              => $projectLabel->id],
                        ['user_id'            => $userId],
                    );
                    unset($projectData['work_on_date']);
                    unset($projectData['enable_sms']);
                    $project->fill($projectData)->save();
                }
            }
            return $id;
        });
    }

    /**
     * 一括削除（複数ID指定）
     *
     * @param Request $request
     * @return json
     */
    public function destroyByMultiId(Request $request)
    {
        $ret = Project::whereIn('id', $request->ids)->delete();
        return response()->noContent();
    }
}
