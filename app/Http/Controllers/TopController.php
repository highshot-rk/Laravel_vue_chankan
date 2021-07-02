<?php

namespace App\Http\Controllers;

use Auth;
use App\Charge;
use App\Project;
use CarbonCarbon;
use Carbon\Carbon;
use App\ChargeRemark;
use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * (ユーザー向け)トップページのController
 */
class TopController extends Controller
{
    /**
     * ルートのルーティング：ログインページへリダイレクト
     *
     * @return void
     */
    public function index()
    {
        return redirect()->route('login');
    }

    public function pdfTest(Request $request)
    {
        $params = $request->all();
        // 1ブロックに表示する情報：
        // 　施工日　projects.work_on
        // 　案件タイプ　projects.projectTypeName()
        // 　時間タイプ　projects.timeTypeName()
        // 　案件名　projects.name
        // 　営業担当者　projects.charge.name
        // 　作業者　projects.worker_name
        // 　住所　projects.address
        // 　元請け会社名　projects.projectOrderer.company

        // ユーザーが所有する　＆　入力された日付の範囲内で案件を取得
        // 日付・時間タイプ・営業担当者IDでソートする
        $user_id     = AuthService::getAuthUser()->id;
        $allProjects = Project::ofUserId($user_id)
            ->ofWorkOnFrom($params['work_on_from'])
            ->ofWorkOnTo($params['work_on_to'])
            ->orderBy('work_on', 'ASC')
            ->orderByRaw('CASE
                WHEN time_type = 1 THEN 1
                WHEN time_type = 2 THEN 2
                WHEN time_type = 0 THEN 3
                ELSE 9999
                END')
            ->orderBy('charge_id', 'ASC')
            ->get();
        $dateArray = Project::ofUserId($user_id)
            ->ofWorkOnFrom($params['work_on_from'])
            ->ofWorkOnTo($params['work_on_to'])
            ->orderBy('work_on', 'ASC')
            ->orderByRaw('CASE
                WHEN time_type = 1 THEN 1
                WHEN time_type = 2 THEN 2
                WHEN time_type = 0 THEN 3
                ELSE 9999
                END')
            ->orderBy('charge_id', 'ASC')
            ->pluck('work_on')
            ->unique();
        // 営業担当者を取得
        $charges = Charge::ofUserId($user_id)->orderBy('id', 'ASC')->get();
        // 営業担当者メモを取得
        $loopAllChargeRemarks = ChargeRemark::ofUserId($user_id)
            ->ofWorkOnFrom($params['work_on_from'])
            ->ofWorkOnTo($params['work_on_to'])
            ->get();
        // 営業担当者・施工日＆時間タイプ　の二軸で、二次元配列を作成する
        // 各日付のループ用の配列を作成
        // $timeTypes = [
        //     config('const.project.time_type.am'),
        //     config('const.project.time_type.pm'),
        //     config('const.project.time_type.none'),
        // ];
        // ループ用のコレクションを作成
        $loopAllProjects      = $allProjects;
        $resultProjects       = [];
        // 日付ごとにループ
        foreach ($dateArray as $date) {
            $isFound   = false;
            // 時間タイプごとに処理
            $timeType = config('const.project.time_type.am');
            self::getProjectArrayData($loopAllProjects, $loopAllChargeRemarks, $resultProjects, $date, $timeType, $charges);
            $timeType = config('const.project.time_type.pm');
            self::getProjectArrayData($loopAllProjects, $loopAllChargeRemarks, $resultProjects, $date, $timeType, $charges);
            $timeType = config('const.project.time_type.none');
            self::getProjectArrayData($loopAllProjects, $loopAllChargeRemarks, $resultProjects, $date, $timeType, $charges);
        }
//         foreach ($resultProjects as $projectLine) {
//             foreach ($projectLine as $project) {
//                 print_r($project->work_on);
//             }
//         }
        $pdf = \PDF::loadView('test_pdf', ['projects' => $resultProjects, 'charges' => $charges, 'showCount' => 4])
            ->setPaper('A4')
            ->setOption('encoding', 'utf-8')
            ->setOption('orientation', 'Landscape')       // 横向き
            ->setOption('enable-local-file-access', true) // ローカルファイルアクセスを有効にする(動作させる為に設定が必要)
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 5)
            ->setOption('margin-right', 5)
            ->setOption('margin-left', 5);
        return $pdf->inline();
        // dd($resultProjects);
        // return view('test_pdf')->with(['projects' => $resultProjects, 'charges' => $charges]);
    }

    public static function getProjectArrayData(&$loopAllProjects, &$loopAllChargeRemarks, &$resultProjects, $date, $timeType, $charges)
    {
        // $loopCount = 0;
        // 該当する案件がなくなるまでループ
        do {
            $lineArray = [];
            $isFound = false;
            // 営業担当者ごとにループ
            foreach ($charges as $charge) {
                // dd('time_type = '.$timeType.', date = '.$date.', charge->id = '.$charge->id);
                // ループ用の案件コレクションおよび営業担当者メモコレクション　を営業担当者IDで検索
                // 見つかったものを抽出し、二次元配列へ格納
                $temp = $loopAllProjects->first(function ($value, $key) use ($charge, $timeType, $date) {
                    return ($value['charge_id'] == $charge->id) && ($value['time_type'] == $timeType) && $date->eq($value['work_on']);
                });
                if ($temp) {
                    // 行の配列へ格納
                    $isFound     = true;
                    $lineArray[] = $temp;
                    // 見つかった要素をコレクションから削除する
                    $loopAllProjects = $loopAllProjects->reject(function ($value) use ($temp) {
                        return $value['id'] == $temp->id;
                    });
                } else {
                    $temp = null;
                    $temp = $loopAllChargeRemarks
                        ->where('charge_id', $charge->id)
                        ->where('time_type', $timeType)
                        ->where('work_on', $date)
                        ->first();
                    if ($temp) {
                        // 行の配列へ格納
                        $isFound     = true;
                        $lineArray[] = $temp;
                        // 見つかった要素をコレクションから削除する
                        $loopAllChargeRemarks = $loopAllChargeRemarks->reject(function ($value) use ($temp) {
                            return $value['id'] == $temp->id;
                        });
                    } else {
                        $lineArray[] = null;
                    }
                }
            }
            if ($isFound) {
                $resultProjects[] = $lineArray;
            }
        } while ($isFound);
        // dd($resultProjects);

        return;
    }

    public function process()
    {
        return view('calendar.table');
    }
}
