@include("../components/head")
<body>
    <div id="app">
		@include("../components/nav")
		<div class="flex__wrap f__start input__area">
			@include("../components/sidebar")
			<div class="wrap__right">
                @include("../components/header")
                    <project-register-component mode="advance_notice" :id="{{ $id }}" is-charge="{{ $isCharge }}" is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}"></project-register-component>
                </div>
			</div>
		</div>
	</body>
	@include("../components/footer")
</body>
</html>
