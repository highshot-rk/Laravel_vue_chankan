@include("../components/head")
<body>
	<div id="app">
		<div class="wrap flex__wrap f__start manage">
	        @include("../components/manage-sidebar")
			<div class="wrap__right">
	            @include("../components/manage-header")
				<div class="allWrapper">
					<div class="content__wrap">
						<div class="content__section">
							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">広告出稿会社一覧</h1>
									<span class="en">Ads List</span>
								</div>

								<div class="content__edit">
									<ul>
										<li><a href="{{ route('admin.advertisements.add') }}">新規追加</a></li>
									</ul>
								</div>
                            </div>
                            <div class="tab">
                                <admin-advertisement-index-sp-component></admin-advertisement-index-sp-component>
                            </div>
                            <div class="pc">
                                <admin-advertisement-index-pc-component></admin-advertisement-index-pc-component>
                            </div>
						</div>
					</div>
				</div>
			</div>
	    </div>
	</div>
    @include("../components/footer")
</body>
</html>
