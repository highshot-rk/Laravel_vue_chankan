@include("../components/head")
<body>
    <div id="app">
		<div class="wrap flex__wrap f__start input__area">
			@include("../components/manage-sidebar")
			<div class="wrap__right">
                @include("../components/manage-header")
                <admin-user-edit-component :id="{{ $id }}" />
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
