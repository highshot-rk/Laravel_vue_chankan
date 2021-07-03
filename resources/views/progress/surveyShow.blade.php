@include("../components/head")
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/luminous-basic.min.css') }}">
<body>
    <div id="app">
        <div class="wrap flex__wrap f__start input__area">
            {{-- @include("../components/sidebar") --}}
            <div class="wrap__center">
            {{-- @include("../components/header") --}}
                <div class="allWrapper">
                    <div class="content__wrap">
                        <div class="content__section">
                            <div class="content__header">
                                <div class="content__title">
                                    <h1 class="h1">現場調査報告</h1>
                                    <span class="en">Survey Report</span>
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

                                            <!-- 複数読み込み -->
                                            @foreach ($survey->surveyImages as $surveyImage)
                                            <div class="content__input">
                                                <div class="input__img flex__wrap showImg">
                                                    <div class="input__img__block" style="margin-right: 0 !important">
                                                        <div class="input__img__block__inner containImg">
                                                            <a class="luminous-target" href="{{ str_replace('public', '/storage', $surveyImage->img) }}">
                                                                <img src="{{ str_replace('public', '/storage', $surveyImage->img) }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p class="textCenter" style="margin-top: 1em;">{{ $surveyImage->description }}</p>
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
            </div>
        </div>
    </div>
    @include("../components/footer")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/luminous-lightbox/2.3.2/luminous.min.js"></script>
    <script>
        new Luminous(document.querySelector('a.luminous-target'));
    </script>
</body>
</html>
