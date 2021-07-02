@include("../components/head")
<body>
	<div id="app">
		<div class="wrap flex__wrap f__start input__area">
			<div class="wrap__center">
	            {{-- @include("../components/header") --}}
	            <client-project-show-component :id="{{ $id }}" :is-open="{{ $isOpen }}"></client-project-show-component>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
