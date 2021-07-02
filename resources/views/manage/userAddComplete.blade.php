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
				<div class="allWrapper">
					<div class="content__wrap">
						<div class="content__section">
							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">会員登録完了</h1>
									<span class="en">User Register Complete</span>
								</div>
							</div>
							<div class="content__floar">
								<div class="content__floar__inner">
									<div class="content__box">
										<div class="content__box__inner">
											<div class="content__text">
												<p>会員新規登録が完了しました。</p>
												<p>登録したメールアドレスに、招待用のメールをお送りしました。</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="content__submit f__center">
							<div class="submit__box">
	                            @can('owner-only')
	                            <a href="{{ route('admin.clients.index') }}">会員一覧へ戻る</a>
	                            @else
	                            <a href="{{ route('admin.home.index') }}">トップへ戻る</a>
	                            @endcan
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

