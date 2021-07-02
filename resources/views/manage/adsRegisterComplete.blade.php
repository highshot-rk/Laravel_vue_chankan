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

	                        {{-- TODO:タイトルや本文は適宜変更する --}}
							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">会員登録完了</h1>
									<span class="en">Member Registration Completed</span>
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
	                    @can('owner-only')
						<div class="content__submit f__center">
							<div class="submit__box">
								<a href="{{ route('admin.advertisements.index') }}">一覧へ戻る</a>
							</div>
	                    </div>
	                    @else
						<div class="content__submit f__center">
							<div class="submit__box">
								<a href="{{ route('admin.home.index') }}">トップへ戻る</a>
							</div>
	                    </div>
	                    @endcan
					</div>
				</div>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>



