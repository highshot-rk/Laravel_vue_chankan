@include("../components/head")
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
                                    <h1 class="h1">案件終了報告</h1>
                                    <span class="en">Project Report</span>
                                </div>
                            </div>
                            <div class="content__floar">
                                <div class="content__floar__inner">
                                    <div class="content__box">
                                        <div class="content__box__inner">
                                            <div class="content__input">
                                                <div class="headline">案件名</div>
                                                <div class="input__text">
                                                    <span>{{ $project->name }}</span>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline">施工日</div>
                                                <div class="input__text">
                                                    <span>{{ $project->workOn() }}</span>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline">終了日</div>
                                                <div class="input__text">
                                                    <span>{{ $project->finished_at->format('Y年m月d日') }}</span>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline">備考</div>
                                                <div class="input__text"></div>
                                                    <span>{{ $project->remark }}</span>
                                                </div>
                                            </div>

                                            <!-- 複数読み込み -->
                                            <div class="content__input">
                                                <div class="input__img flex__wrap showImg">
                                                    <div class="input__img__block">
                                                        <div class="input__img__block__inner containImg">
                                                            <img src="/{{ $project->finish_img }}">
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
                </div>
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
