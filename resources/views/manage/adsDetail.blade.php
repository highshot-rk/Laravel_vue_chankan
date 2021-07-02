@include("../components/head")
<body id="manageBody">
	<div id="app">
		<div class="wrap flex__wrap f__start input__area">
			@include("../components/manage-sidebar")
			<div class="wrap__right">
	            @include("../components/manage-header")
	            
	            <admin-advertisement-show-component :id={{ $id }}></admin-advertisement-show-component>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
