@include("../components/head")
<body>
	<div id="app">
		@include("../components/nav")
		<div class="wrap flex__wrap f__start input__area">
			@include("../components/sidebar")
			<div class="wrap__right">
                @include("../components/header")
                <project-register-component
                    mode="register"
                    :id="0"
                    login_id="{{ $login_id }}"
                    user_id="{{ $user_id }}"
                    work_on_y="{{ $work_on_y }}"
                    work_on_m="{{ $work_on_m }}"
                    work_on_d="{{ $work_on_d }}"
                    is-charge="{{ $isCharge }}"
                    is-viewer="{{ $isViewer }}"
                    url-prefix="{{ $urlPrefix }}"
                ></project-register-component>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
