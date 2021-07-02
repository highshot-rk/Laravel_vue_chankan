
@include("../components/head-process")

<body>
    <div id="app">
        {{-- @include("../components/nav") --}}
        <div class="wrap l-flex f__start">
            <board is-charge="{{ $isCharge }}" is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}"></board>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
