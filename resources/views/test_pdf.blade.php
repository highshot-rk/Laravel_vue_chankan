<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body {
      min-height: 100vh;
      height: 100vh;
      overflow: hidden;
      padding-bottom: 10px;
    }

    a {
      cursor: pointer;
    }

    #proccess-header {
      position: relative;
      padding: 20px 0;
      z-index: 100000;
    }

    .proccess-header-inner {
      padding: 0 20px;
    }

    /*-----------------------------------------------------------------------------------------



  add



------------------------------------------------------------------------------------------*/
    .content__wrap .content__floar {
      background: #fff;
      padding: 46px;
      border-radius: 20px;
      box-shadow: rgba(146, 159, 181, 0.1) 0px 0px 10px;
    }

    /*-----------------------------------------------------------------------------------------



  common



------------------------------------------------------------------------------------------*/
    .proccess__wrap {
      padding: 0 20px;
      height: 100%;
    }

    .proccess__wrap__inner {
      height: 100%;
    }

    /*-----------------------------------------------------------------------------------------



  header



------------------------------------------------------------------------------------------*/
    .proccess__button li {
      position: relative;
    }

    .proccess__button a {
      position: relative;
      display: block;
      min-height: 40px;
      height: 40px;
      line-height: 40px;
      padding: 0 20px;
      background: #fff;
      font-weight: 700;
    }

    .proccess__button a.calendarButton {
      padding: 0;
    }

    .proccess__button .vdp-datepicker {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      height: 100%;
    }

    .proccess__button .vdp-datepicker>div:not(.vdp-datepicker__calendar),
    .proccess__button .vdp-datepicker input {
      display: block;
      height: 100%;
    }

    .proccess__back a {
      font-size: 16px;
      font-weight: 700;
      color: #929FB5;
    }

    .proccess__calendar li {
      margin-right: 5px;
    }

    .proccess__calendar li:nth-child {
      margin-right: 0;
    }

    /*-----------------------------------------------------------------------------------------



  main



------------------------------------------------------------------------------------------*/
    .process-table {
      position: relative;
      width: 100%;
      /* height: -webkit-calc(100vh - 88px);
            height: calc(100vh - 88px);
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch; */
    }

    .process-table-tr {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      border-bottom: 1px solid #F1F3F6;
    }

    .process-table-th.day {
      /* position: sticky; */
      left: 0px;
      z-index: 100;
    }

    .process-table-th.first,
    .process-table-th.time {
      /* position: sticky; */
      left: 100px;
      z-index: 100;
    }

    .process-table-thead {
      /* position: sticky; */
      top: 0;
      z-index: 10000;
      padding-bottom: -50px;
      padding-right: 20px;
    }

    .process-table-thead .process-table-th {
      width: 260px;
      min-width: 260px;
      height: 45px;
      line-height: 45px;
      border-right: 1px solid #F1F3F6;
      text-align: center;
      font-weight: 700;
      border-bottom: 5px solid #F1F3F6;
    }

    .process-table-thead .process-table-th.day {
      width: 100px;
      min-width: 100px;
      background: #F1F3F6;
    }

    .process-table-thead .process-table-th.first {
      width: 120px;
      min-width: 120px;
      border-radius: 5px 0 0;
      background: #fff;
    }

    .process-table-thead .process-table-th.name {
      background: #fff;
    }

    .process-table-tbody {
      position: absolute;
      top: 47px;
      padding-right: 20px;
      height: 500px;
      height: -webkit-calc(100vh - 134px);
      height: calc(100vh - 134px);
    }

    .process-table-tbody .process-table-tbody__content {
      margin-top: -46px;
      padding-top: 46px;
    }

    .process-table-tbody .process-table-th,
    .process-table-tbody .process-table-td {
      height: 150px;
      border-right: 1px solid #F1F3F6;
      vertical-align: bottom;
    }

    .process-table-tbody .process-table-th {
      width: 120px;
      min-width: 120px;
    }

    .process-table-tbody .process-table-th.day {
      width: 100px;
      min-width: 100px;
      font-weight: 700;
      color: #929FB5;
      background: #F1F3F6;
    }

    .process-table-tbody .process-table-th:not(.day) {
      background: #fff;
    }

    .process-table-tbody .process-table-td {
      width: 260px;
      background: #fff;
    }

    .work-field .work-field-block {
      width: 100px;
      margin: auto;
    }

    .work-field__time {
      width: 120px;
      height: 150px;
    }

    .work-field__time__inner {
      position: relative;
      text-align: center;
      font-weight: 700;
    }

    .field-edit .field-button {
      display: block;
      width: 40px;
      border-radius: 3px;
      height: 17px;
      line-height: 17px;
      color: #fff;
    }

    .field-edit .field-button.field-add {
      background: #6495ed;
    }

    .field-edit .field-button.field-delete {
      background: #D13B3B;
      margin-left: 5px;
    }

    .work-field__work {
      width: 260px;
      height: 150px;
      position: relative;
    }

    .work-field__work .work-field__work__inner {
      width: 250px;
      height: 140px;
      margin: auto;
    }

    .work-field__work .field__work__content {
      cursor: pointer;
      height: 100%;
      width: 100%;
      margin: auto;
      z-index: 10;
      position: relative;
    }

    .work-field__work__button {
      z-index: 1;
      position: absolute;
      left: 10px;
      right: 10px;
      bottom: 10px;
      top: 10px;
      width: 130px;
      height: 130px;
      border: dashed 3px #EBEBEB;
    }

    .work-field__work__button .work-field__work__button__inner {
      height: 100%;
      width: 100%;
    }

    .work-field__work__button .add-button {
      position: relative;
      text-align: center;
      display: block;
      width: 70px;
      height: 20px;
      line-height: 20px;
      font-weight: 700;
      color: #C1CBD8;
      background: #F1F3F6;
    }

    .work-field__work__button .add-button.work-add {
      margin-bottom: 5px;
    }

    /*-----------------------------------------------------------------------------------------



  main - memo



------------------------------------------------------------------------------------------*/
    .memoContent {
      /* overflow: auto; */
      height: 100%;
      width: 100%;
      margin: auto;
      background: #F7FFE0;
      padding: 10px;
      z-index: 1;
    }

    .memoContent .memoContent__inner {
      /* overflow-y: scroll; */
      word-break: break-all;
    }

    .memoContent .memoContent__inner textarea {
      min-height: 120px;
    }

    .workContent {
      z-index: 10;
      /* overflow: auto; */
      height: 100%;
      width: 100%;
      margin: auto;
      background: #fff;
    }

    .workContent__inner {
      list-style: none;
    }

    .workContent__inner li {
      font-size: 10px;
      height: 24px;
      line-height: 24px;
      padding: 0 3px;
      border-bottom: #F1F3F6 1px dashed;
    }

    .workContent__inner li:first-child,
    .workContent__inner li:last-child {
      height: auto;
      line-height: auto;
      padding-top: 5px;
      border-bottom: none;
    }

    .workContent__inner li:last-child {
      line-height: 1.2;
      /* overflow-y: scroll; */
    }

    .workContent__inner li a {
      color: #172DD6;
      text-decoration: underline;
    }

    .workContent__inner li span {
      height: 16px;
      line-height: 16px;
    }

    .workContent__inner li span.work {
      width: 36px;
      text-align: center;
      border-radius: 3px;
      color: #fff;
      font-weight: 700;
    }

    .workContent__inner li span.erecting {
      background: #6A87C9;
      padding: 2px 8px;
    }

    .workContent__inner li span.dismantling {
      background: #C96A6A;
      padding: 2px 8px;
    }

    .workContent__inner li span.beforeContact a {
      display: inline-block;
      background: #000000;
      color: #fff;
      padding: 0 7px;
      border-radius: 3px;
      color: #fff;
      text-decoration: none;
      font-weight: 700;
    }

    .border-color__pink {
      border-bottom: 1px solid #C96A6A;
    }

    /*-----------------------------------------------------------------------------------------



  modal



------------------------------------------------------------------------------------------*/
    .modal-wrap {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      overflow-y: auto;
      visibility: hidden;
      opacity: 0;
      z-index: -1;
      background: rgba(0, 0, 0, 0.3);
    }

    .modal-wrap.is-open {
      visibility: visible;
      opacity: 1;
      z-index: 100;
    }

    .modal-wrap.memo-modal {
      z-index: 100001;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    .modal-wrap.work-modal {
      z-index: 100001;
      justify-content: center;
      display: flex;
    }

    .modal-wrap.work-modal .content__floar {
      margin: 60px auto;
    }

    .modal-wrap .content__floar {
      width: 570px;
      margin: auto;
    }

    .selectColor .colorBox {
      position: relative;
      background: #fff;
    }

    .selectColor .colorBox input[type=radio] {
      width: 40px;
      height: 40px;
      opacity: 0;
    }

    .selectColor .colorBox input[type=radio]:checked+label {
      opacity: 0.3;
    }

    .selectColor .colorBox label {
      position: absolute;
      display: block;
      left: 0;
      top: 0;
      height: 40px;
      width: 100%;
      cursor: pointer;
      pointer-events: none;
      border-radius: 3px;
    }

    .selectColor .colorBox.one label {
      background: #ff0000;
    }

    .selectColor .colorBox.two label {
      background: #ff00ff;
    }

    .selectColor .colorBox.three label {
      background: #7f00ff;
    }

    .selectColor .colorBox.four label {
      background: #0000ff;
    }

    .selectColor .colorBox.five label {
      background: #007fff;
    }

    .selectColor .colorBox.six label {
      background: #00ffff;
    }

    .selectColor .colorBox.seven label {
      background: #00ff00;
    }

    .selectColor .colorBox.eight label {
      background: #7fff00;
    }

    .selectColor .colorBox.nine label {
      background: #ffff00;
    }

    .selectColor .colorBox.ten label {
      background: #ff7f00;
    }

    .page-break {
        page-break-after: always;
    }
  </style>
  <title>Title</title>
</head>

<body>
  <h1>工程表</h1>
  <?php
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
@if ($loopIndex % 5 === 1 || $_prevChargeIndex != $chargeIndex)
    <?php
      $_prevChargeIndex = $chargeIndex;
    ?>
  <div class="proccess">
    {{-- <main> --}}
        <div class="proccess__wrap">
          <div class="proccess__wrap__inner">
            <div class="process-table">
            <div class="process-table-thead">
              <div class="process-table-tr">
                <div class="process-table-th day"></div>
                <div class="process-table-th first"></div>
                  @for ($i = 0; $i < $showCount; $i ++)
                      @if (isset($charges[$chargeIndex + $i]->name))
                          <div class="process-table-th name">{{ $charges[$chargeIndex + $i]->name }}</div>
                      @endif
                  @endfor
              </div>
            </div>
            <div class="process-table-tbody">
@endif
              <?php $prevWorkOn   = null ?>
              <?php $prevTimeType = null ?>
              {{-- 常に表示するSTART --}}
              <div class="process-table-tbody__content">
                <div class="process-table-tr work-field am-column">
                  <div class="process-table-th day">
                      @foreach ($projectLine as $project)
                          @if (isset($project))
                            @if (date_format($project->work_on, 'Y-m-d') !== $prevWorkOn)
                                {{ date_format($project->work_on, 'm/d(D)') }}
                                <?php break; ?>
                            @endif
                          @endif
                      @endforeach
                  </div>
                  <?php $prevWorkOn = date_format($project->work_on, 'Y-m-d') ?>
                  <div class="process-table-th time">
                    <div class="work-field__time flex__wrap f__center v__center">
                      <div class="work-field__time__inner">
                        <p>
                        @if ($project->time_type !== $prevTimeType)
                          {{ $project->timeTypeProcessName() }}
                          @endif
                        </p>
                      </div>
                    </div>
                  </div>
                  <?php $prevTimeType = $project->time_type ?>
                  @foreach ($projectLine as $projectIndex =>  $project)
                      @if ($projectIndex >= $chargeIndex && $projectIndex < $chargeIndex + $showCount)
                  <div class="process-table-td">
                    <div class="work-field__work flex__wrap f__center v__center">
                      <div class="work-field__work__inner">
                        <div class="field__work__content" draggable="false">
                          <div class="workContent">
                            @if ($project instanceof App\Project)
                            {{-- 案件の場合の表示 --}}
                            <ul class="workContent__inner">
                              <li class="flex__wrap">
                                <span class="work erecting">{{ $project->projectTypeName() }}</span>
                              </li>
                              <li>{{ $project->name }}</li>
                              <li>{{ $project->worker }}</li>
                              <li>{{ $project->charge->name }}</li>
                              <li>{{ $project->projectOrderer->company }}</li>
                              <li>{{ $project->address }}</li>
                              <li></li>
                            </ul>
                            @elseif ($project instanceof App\ChargeRemark)
                            {{-- メモの場合の表示 --}}
                            <ul class="workContent__inner">
                              <li>{{ $project->remarks }}</li>
                            </ul>
                            @else
                            {{-- 空の場合の表示 --}}
                            <ul class="workContent__inner">
                              <li></li>
                            </ul>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                        @endif
                  @endforeach
                </div>
              </div>
              {{-- 常に表示するEND --}}
@if ($loopIndex % 5 === 0)
            </div>
          </div>
        </div>
      </div>
    {{-- </main> --}}
  </div>
  @if ($lineIndex < $_projectCount - 1)
  <div class="page-break"></div>
  @endif
@endif
  @endforeach

  @if ($chargeIndex < $_chargeCount)
  </div>
  </div>
  </div>
  </div>
  {{-- </main> --}}
  </div>
  @endif

  @endfor
</body>

</html>
