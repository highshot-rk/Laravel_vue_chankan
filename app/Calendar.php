<?php

namespace App;

use App\Services\AuthService;

class Calendar
{
    private $html;
    public function showCalendarTag($m, $y)
    {
        $urlPrefix = AuthService::getUrlPrefix();
        $charge = AuthService::getAuthCharge();
        $year = $y;
        $month = $m;
        if ($year == null) {
            // システム日付を取得する。
            $year = date("Y");
            $month = date("m");
        }
        $firstWeekDay = date("w", mktime(0, 0, 0, $month, 1, $year)); // 1日の曜日(0:日曜日、6:土曜日)
        $lastDay = date("t", mktime(0, 0, 0, $month, 1, $year)); // 指定した月の最終日
        // 日曜日からカレンダーを表示するため前月の余った日付をループの初期値にする
        $day = 1 - $firstWeekDay;
        // 翌月表示機能
        $prev = strtotime('-1 month',mktime(0, 0, 0, $month, 1, $year));
        $prev_year = date("Y",$prev);
        $prev_month = date("m",$prev);
        // 翌月
        $next = strtotime('+1 month',mktime(0, 0, 0, $month, 1, $year));
        $next_year = date("Y",$next);
        $next_month = date("m",$next);
        if ($urlPrefix == '/charge') {
            if (!is_null($charge) && ($charge->edit_type == config('const.charge.edit_type.edit'))) {
                $this->html = '<table class="table_longpress charge">';
            } else {
                $this->html = '<table>';
            }
        } else {
            $this->html = '<table class="table_longpress user">';
        }
        $this->html .= <<< EOS

        <thead>
            <tr>
                <th></th>
                <th><a class="prev" href="{$urlPrefix}/calendar?year={$prev_year}&month={$prev_month}" role="button"><img src="/assets/img/icon_arrow_left_black.png"></a></th>
                <th colspan="3">{$year}年{$month}月</th>
                <th><a class="next" href="{$urlPrefix}/calendar?year={$next_year}&month={$next_month}" role="button"><img src="/assets/img/icon_arrow_right_black.png"></a></th>
                <th></th>
            </tr>
        </thead>

        <tr>
            <th class="sun" scope="col">日</th>
            <th scope="col">月</th>
            <th scope="col">火</th>
            <th scope="col">水</th>
            <th scope="col">木</th>
            <th scope="col">金</th>
            <th class="sat" scope="col">土</th>
        </tr>
        EOS;
        // カレンダーの日付部分を生成する
        while ($day <= $lastDay) {
            $this->html .= "<tr>";
            // 各週を描画するHTMLソースを生成する
            for ($i = 0; $i < 7; $i++) {
                if ($day <= 0 || $day > $lastDay) {
                    // 先月・来月の日付の場合
                    $this->html .= "<td>&nbsp;</td>";
                } else {
                    // 案件情報の有無により、カウント値、リンク付与の有無を決定
                    $date        = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    // $amProjects  = Project::whereDate('work_on', $date)
                    //     ->ofUserId(AuthService::getAuthUser()->id)
                    //     ->ofTimeType([config('const.project.time_type.am')])
                    //     ->count();
                    // $pmProjects  = Project::whereDate('work_on', $date)
                    //     ->ofUserId(AuthService::getAuthUser()->id)
                    //     ->ofTimeType([config('const.project.time_type.pm')])
                    //     ->count();
                    $allProjects = Project::whereDate('work_on', $date)
                        ->ofUserId(AuthService::getAuthUser()->id)
                        ->count();
                    $allMemos = ChargeRemark::whereDate('work_on', $date)
                        ->ofUserId(AuthService::getAuthUser()->id)
                        ->count();
                    $link = '';
                    // if (($amProjects > 0) || ($pmProjects > 0)) {
                    //     $link = $urlPrefix.'/projects?work_on='.$date;
                    // }
                    if (($allProjects > 0)) {
                        $link = $urlPrefix.'/projects?work_on='.$date;
                    }
                    $todayDay = date("d");
                    $todayMonth = date("m");

                    $param_date = "y=" . $year . "&m=" . $month . "&d=" . sprintf("%02d", $day);
                    // if (($amProjects == 0) && ($pmProjects == 0)) {
                    if (($allProjects == 0)) {
                        $this->html .= "<td id=\"" . $param_date . "\">" . "<a>";
                    } else {
                        $this->html .= "<td id=\"" . $param_date . "\">" . "<a class='linkCalender' href=" . $link . ">";
                    }
                    if ($todayDay == $day && $todayMonth == $month) {
                        $this->html .= "<div class='top'><span class='date today'>" . $day . "</span>";
                    } else {
                        $this->html .= "<div class='top'><span class='date'>" . $day . "</span>";
                    }
                    // $this->html .= "</div><ul><li><span class='time'>AM - " . $amProjects . "</span></li><li><span class='time'>PM - " . $pmProjects . "</span></li></ul></a></td>";
                    $this->html .= "</div><ul><li><span class='time'>案件 - " . $allProjects . "</span></li><li><span class='time'>メモ - " . $allMemos . "</span></li></ul></a></td>";
                }
                $day++;
            }

            $this->html .= "</tr>";
        }
        return $this->html .= '</table>';
    }
}
