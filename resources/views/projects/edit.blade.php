@include("../components/head")
<body>
	<div id="app">
		@include("../components/nav")
		<div class="wrap flex__wrap f__start input__area">
			@include("../components/sidebar")
			<div class="wrap__right">
	            @include("../components/header")

	            <project-register-component mode="edit" :id="{{ $id }}" is-charge="{{ $isCharge }}" is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}"></project-register-component>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
