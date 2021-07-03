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
                            <daily-project-sp-component
                                work-on="{{ $workOn }}"
                                is-charge="{{ $isCharge }}"
                                is-viewer="{{ $isViewer }}"
                                url-prefix="{{ $urlPrefix }}"
                            />
                        </div>
                        <!-- PC表示 -->
                        <div class="pc">
                            <daily-project-pc-component
                                work-on="{{ $workOn }}"
                                is-charge="{{ $isCharge }}"
                                is-viewer="{{ $isViewer }}"
                                url-prefix="{{ $urlPrefix }}"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>

</html>
