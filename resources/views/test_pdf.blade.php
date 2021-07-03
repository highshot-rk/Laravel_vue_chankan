<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>工程表PDF</title>
    <style>
        html {
            -webkit-text-size-adjust: 100%; /* 2 */
            -webkit-tap-highlight-color: transparent; /* 3*/
        }
        body {
            font-family: "Hiragino Kaku Gothic Pro", "ヒラギノ角ゴ Pro", "Yu Gothic Medium", "游ゴシック Medium", YuGothic, "游ゴシック体", "メイリオ", sans-serif;
            color: #333;
        }
        *, ::before, ::after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            border-style: solid;
            border-width: 0;
        }
        .proccess__wrap {
            padding: 0 20px;
            height: 100%;
        }
        .proccess__wrap__inner {
            height: 100%;
        }
        .proccess__wrap__inner table {
            border: none;
            border-collapse: collapse;
        }

        .proccess__wrap__inner thead {
            border: none;
            height: 35px;
        }
        .proccess__wrap__inner thead th,
        .proccess__wrap__inner thead td {
            padding: 0px 10px;
            height: 35px;
        }
        .proccess__wrap__inner thead th:nth-child(n+3) {
            width: 140px;
            background: #F1F3F6;
        }
        .proccess__wrap__inner tbody {
            border: none;
        }
        .proccess__wrap__inner tbody th {
            font-weight: 400;
        }
        .proccess__wrap__inner tbody th.th-date {
            border-top: 1px solid #e2e2e2;
            border-right: 1px solid #e2e2e2;
            border-left: 1px solid #e2e2e2;
            border-bottom: 1px solid #e2e2e2;
            background: #F1F3F6;
            font-weight: 700;
            vertical-align: top;
            line-height: 60px;
            padding: 0 5px;
        }
        .proccess__wrap__inner tbody th.th-date-other {
            background: #F1F3F6;
            border-top: 0;
            border-right: 1px solid #e2e2e2;
            border-left: 1px solid #e2e2e2;
            border-bottom: 0;
        }
        .proccess__wrap__inner tbody th.th-headline {
            background: #F1F3F6;
            font-weight: 700;
            padding: 0 5px;
        }
        .proccess__wrap__inner tbody th,
        .proccess__wrap__inner tbody td {
            height: 138px;
            font-size: 15px;
        }
        .proccess__wrap__inner tr {
            border: none;
            page-break-inside: avoid;
        }
        .proccess__wrap__inner tr:nth-child(3n) {
            border-bottom: 1px solid #e2e2e2;
            border: 3px solid pink
        }
        .proccess__wrap__inner th,
        .proccess__wrap__inner td {
            border: 1px solid #e2e2e2;
        }
        .proccess__wrap__inner ul {
            list-style: none;
            font-size: 14px;
            background: #fbfbfb;
            width: 100%;
            height: 100%;
            margin: 0;
        }
        .proccess__wrap__inner table li {
            margin-bottom: 5px;
            border-top: 0;
            border-right: 0;
            border-left: 0;
            padding-left: 5px;
            padding-right: 5px;
            height: 19px;
            border-bottom: 1px solid #f4f4f4;
            font-size: 14px
        }
        .proccess__wrap__inner table li:first-child {
            padding-top: 3px;
        }
        .proccess__wrap__inner table li:last-child {
            margin-bottom: 0;
            padding-bottom: 10px;
            border-bottom: none;
        }
        .proccess__wrap__inner table li.one:last-child {
            border-bottom: 2px solid rgb(213, 0, 0);
        }
        .proccess__wrap__inner table li.two:last-child {
            border-bottom: 2px solid rgb(230, 124, 115);
        }
        .proccess__wrap__inner table li.three:last-child {
            border-bottom: 2px solid rgb(244, 81, 30);
        }
        .proccess__wrap__inner table li.four:last-child {
            border-bottom: 2px solid rgb(246, 191, 38);
        }
        .proccess__wrap__inner table li.five:last-child {
            border-bottom: 2px solid rgb(51, 182, 121);
        }
        .proccess__wrap__inner table li.six:last-child {
            border-bottom: 2px solid rgb(11, 128, 67);
        }
        .proccess__wrap__inner table li.seven:last-child {
            border-bottom: 2px solid rgb(3, 155, 229);
        }
        .proccess__wrap__inner table li.eight:last-child {
            border-bottom: 2px solid rgb(63, 81, 181);
        }
        .proccess__wrap__inner table li.nine:last-child {
            border-bottom: 2px solid rgb(121, 134, 203);
        }
        .proccess__wrap__inner table li.ten:last-child {
            border-bottom: 2px solid rgb(97, 97, 97);
        }
        /* --- option  --- */
        .proccess__wrap__inner .no-border {
            border: none !important;
        }
        .proccess__wrap__inner .no-color {
            background: #fff !important;
        }
    </style>
</head>
<body>
    <h1>工程表</h1>
    <?php
        $charges = $charges_other;
        $_chargeIndex = 0;
        $_chargeCount = count($charges);
        $_prevChargeIndex = 0;
        $_projectCount = count($projects);
        $_first = true;
        $_print = false;
    ?>
    @for ($chargeIndex = 0; $chargeIndex < $_chargeCount; $chargeIndex += $showCount)
        @foreach ($projects as $lineIndex => $projectLine)
            <?php $_exist = false; ?>
            @foreach ($projectLine as $projectIndex => $project)
                @if ($projectIndex >= $chargeIndex && $projectIndex < $chargeIndex + $showCount)
                    @if ($project instanceof App\Project)
                        <?php $_exist = true; break; ?>
                    @elseif ($project instanceof App\ChargeRemark)
                        <?php $_exist = true; break; ?>
                    @endif
                @endif
            @endforeach
            <?php if (!$_exist) continue; ?>
            <?php break; ?>
        @endforeach


        @if (!$_first && $_print && $lineIndex < $_projectCount - 1)
            <div class="page-break"></div>
        @endif
        <?php $_first = false; ?>
        <?php
            $loopIndex = 0;
            $_print = false;
        ?>
        @foreach ($projects as $lineIndex => $projectLine)

            <?php $_exist = false; ?>
            @foreach ($projectLine as $projectIndex => $project)
                @if ($projectIndex >= $chargeIndex && $projectIndex < $chargeIndex + $showCount)
                    @if ($project instanceof App\Project)
                        <?php $_exist = true; break; ?>
                    @elseif ($project instanceof App\ChargeRemark)
                        <?php $_exist = true; break; ?>
                    @endif
                @endif
            @endforeach
            <?php if (!$_exist) continue; ?>
            <?php
                $loopIndex ++;
                $_print = true;
            ?>

        {{-- @if ($loopIndex % 5 === 1 || $_prevChargeIndex != $chargeIndex) --}}
        @if ($loopIndex % 6 === 1 || $_prevChargeIndex != $chargeIndex)
        <?php
            $_prevChargeIndex = $chargeIndex;
        ?>
        <div class="proccess" >
            <div class="proccess__wrap">
                <div class="proccess__wrap__inner">
                    <table style="width: 99%; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th class="no-border no-color" style="width: 6%;"></th>
                                <th class="no-border no-color" style="width: 6%;"></th>
                                @php $kk = 0; @endphp
                                @for ($i = 0; $i < $showCount; $i ++)
                                    @if (isset($charges[$chargeIndex + $i]->name))
                                    @php
                                        $kk++;
                                    @endphp
                                    <th style="width: 11%;">{{ mb_strimwidth($charges[$chargeIndex + $i]->name, 0, 12, '…') }}</th>
                                    @endif
                                @endfor
                                @if($kk !== 8)
                                <td style="width: {{88-11*$kk}}%; background-color:white; border-color:white;" ></td>
                                @endif
                            </tr>
                        </thead>
                        @endif
                        <tbody>
                        <?php $prevWorkOn   = null ?>
                        <?php $prevTimeType = null ?>
                            {{-- 日程 AM/PM/案件調整 START --}}
                            <tr>
                                @foreach ($projectLine as $project)
                                    @if (isset($project))
                                        @if (date_format($project->work_on, 'Y-m-d') !== $prevWorkOn)
                                            @php
                                                $day = date_format($project->work_on, 'D');
                                                if ($day == "Mon"){
                                                    $japen_day = "月";
                                                } elseif($day == "Tue") {
                                                    $japen_day = "火";
                                                } elseif($day == "Wed") {
                                                    $japen_day = "水";
                                                } elseif($day == "Thu") {
                                                    $japen_day = "木";
                                                } elseif($day == "Fri") {
                                                    $japen_day = "金";
                                                } elseif($day == "Sat") {
                                                    $japen_day = "土";
                                                } else {
                                                    $japen_day = "日";
                                                }
                                            @endphp
                                            <th class="th-date">{{ date_format($project->work_on, 'm/d') }} {{$japen_day}}</th>
                                            <?php break; ?>
                                        @endif
                                    @endif
                                @endforeach
                                <?php $prevWorkOn = date_format($project->work_on, 'Y-m-d');  ?>
                                @if ($project->time_type !== $prevTimeType)
                                <th class="th-headline">
                                    {{ $project->timeTypeProcessName() }}
                                </th>
                                @endif
                                <?php $prevTimeType = $project->time_type ?>

                                @foreach ($projectLine as $projectIndex =>  $project)
                                    @if ($projectIndex >= $chargeIndex && $projectIndex < $chargeIndex + $showCount)
                                        <td>
                                            {{--  案件の場合  --}}
                                            @if ($project instanceof App\Project)
                                                <ul>
                                                    <li>{{ mb_strimwidth($project->projectTypeName(), 0, 9, '…') }}</li>
                                                    <li>{{ mb_strimwidth($project->name, 0, 9, '…') }}</li>
                                                    <li>{{ mb_strimwidth($project->worker_id, 0, 9, '…') }}</li>
                                                    <li>{{ mb_strimwidth($project->charge->name, 0, 9, '…') }}</li>
                                                    <li>{{ mb_strimwidth($project->projectOrderer->company, 0, 9, '…') }}</li>
                                                    @if($project->process_color_id == 1)<li class="one">
                                                    @elseif($project->process_color_id == 2)<li class="two">
                                                    @elseif($project->process_color_id == 3)<li class="three">
                                                    @elseif($project->process_color_id == 4)<li class="four">
                                                    @elseif($project->process_color_id == 5)<li class="five">
                                                    @elseif($project->process_color_id == 6)<li class="six">
                                                    @elseif($project->process_color_id == 7)<li class="seven">
                                                    @elseif($project->process_color_id == 8)<li class="eight">
                                                    @elseif($project->process_color_id == 9)<li class="nine">
                                                    @elseif($project->process_color_id == 10)<li class="ten">
                                                    @else<li>
                                                    @endif
                                                    {{ mb_strimwidth($project->address, 0, 9, '…') }}</li>
                                                </ul>
                                            @elseif ($project instanceof App\ChargeRemark)
                                            {{--  メモの場合  --}}
                                                <ul><li>{{ mb_strimwidth($project->remarks, 0, 70, '…') }}</li></ul>
                                            @else
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        </tbody>
                        @if ($loopIndex % 5 === 0)
                            @if ($lineIndex < $_projectCount - 1)
                            @endif
                        @endif
                        @if ($loopIndex % 6 === 1 || $_prevChargeIndex != $chargeIndex)
                        <div style="height:10px;"></div>
                        @endif
                </div>
            </div>
        </div>
        @endforeach
@if ($chargeIndex < $_chargeCount)
@endif
@endfor
</body>
</html>
