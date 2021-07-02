@include("../components/head")
<body>
    <div id="app">
		<div class="wrap flex__wrap f__start input__area">
            @auth('web')
            @include("../components/sidebar")
            @endauth
            @auth('charge')
            @include("../components/sidebar")
            @endauth
			<div class="wrap__center">
                @auth('web')
				@include("../components/header")
                @endauth
                @auth('charge')
				@include("../components/header")
                @endauth
                    <client-project-report-component id="{{ $id }}"></client-project-report-component>
            </div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
