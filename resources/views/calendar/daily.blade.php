@include("../components/head")

<body>
    <div id="app">
        @include("../components/nav")
        <div class="wrap flex__wrap f__start">
            @include("../components/sidebar")
            <div class="wrap__right">
                @include("../components/header")
                <div class="allWrapper">
                    <div class="content__wrap">
                        <!-- スマホ表示 -->
                        <div class="tab">
                            <daily-project-sp-component work-on="{{ $workOn }}" is-charge="{{ $isCharge }}"
                                is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}">
                            </daily-project-sp-component>
                        </div>
                        <div class="pc">
                            <!-- PC表示 -->
                            <daily-project-pc-component work-on="{{ $workOn }}" is-charge="{{ $isCharge }}"
                                is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}">
                            </daily-project-pc-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>

</html>
