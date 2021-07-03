
@include("../components/head")
<body>
    <div id="app">
        @include("../components/nav")
            <div class="wrap flex__wrap f__start input__area">
            @include("../components/sidebar")
            <div class="wrap__right">
                @include("../components/header")
                <survey-register-component
                    project_id="{{ $project_id }}"
                    enable_sms="{{ $enable_sms }}"
                    mode="register"
                    is-charge="{{ $isCharge }}"
                    is-viewer="{{ $isViewer }}"
                    url-prefix="{{ $urlPrefix }}"
                />
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
