@include("../components/head")
<body>
    <div id="app">
		<div class="wrap flex__wrap f__start input__area">
            @can('owner-only')
            @include("../components/manage-sidebar")
            @endcan
			<div class="wrap__right">
                @can('owner-only')
                @include("../components/manage-header")
                @endcan
                <admin-user-register-component></admin-user-register-component>
            </div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
