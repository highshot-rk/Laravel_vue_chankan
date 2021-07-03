
@include("../components/head")
<body>
    <div id="app">
    <!-- スマホのみのメニューバー -->
    @auth
    @include("../components/nav")
    @endauth
    <div class="wrap flex__wrap f__start input__area">
        @auth
        @include("../components/sidebar")
        <div class="wrap__right">
        @else
        <div class="wrap__center">
        @endauth

        @auth
        @include("../components/header")
        @endauth
        @if (!$isViewer)
        {{-- ユーザーもしくは担当者(編集者)でログインしている場合、内容を編集可能 --}}
        <div id="app">
            <survey-register-component
                project_id="{{ $project_id }}"
                survey_id="{{ $survey_id }}"
                enable_sms="{{ $enable_sms }}"
                mode="edit"
                is-charge="{{ $isCharge }}"
                is-viewer="{{ $isViewer }}"
                url-prefix="{{ $urlPrefix }}"
            />
        </div>
        @else
        {{-- 担当者(閲覧者)でログインしている場合、表示のみ --}}
        <div class="allWrapper">
            <div class="content__wrap">
                <div class="content__section">
                    <div class="content__header">
                        <div class="content__title">
                            <h1 class="h1">現場調査報告</h1>
                            <span class="en">Survey</span>
                        </div>
                    </div>

                    <div class="content__floar">
                        <div class="content__floar__inner">
                            <div class="content__box">
                                <div class="content__box__inner">

                                <div class="content__input">
                                    <div class="headline">案件名</div>
                                        <div class="input__text">
                                            <span>{{ $survey->projectLabel->project->name }}</span>
                                        </div>
                                    </div>
                                    <div class="content__input">
                                        <div class="headline">施工日</div>
                                            <div class="input__text">
                                                <span>{{ $survey->projectLabel->project->workOn() }}</span>
                                            </div>
                                        </div>
                                        <div class="content__input">
                                            <div class="headline">備考</div>
                                                <div class="input__text remark">
                                                    <span>{{ $survey->remark }}</span>
                                                </div>
                                            </div>

                                            {{--  複数読み込み  --}}
                                            @foreach ($survey->surveyImages as $surveyImage)
                                            <div class="content__input">
                                                <div class="input__img flex__wrap showImg">
                                                    <div class="input__img__block">
                                                        <div class="input__img__block__inner containImg">
                                                            <img src="{{ asset($surveyImage->img) }}">
                                                        </div>
                                                    </div>
                                                    <div><p style="margin-top: 1em;">{{ $surveyImage->description }}</p></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
