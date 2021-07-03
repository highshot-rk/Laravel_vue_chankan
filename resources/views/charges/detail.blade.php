@include("../components/head")
<body>
	<div id="app">
		<!-- スマホのみのメニューバー -->
		@include("../components/nav")
		<div class="wrap flex__wrap f__start input__area">
			@include("../components/sidebar")
			<div class="wrap__right">
                @include("../components/header")
                <charge-show-component :id="{{ $id }}" is-success="{{ session('success-message') }}" is-charge="{{ $isCharge }}" is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}"></charge-show-component>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
