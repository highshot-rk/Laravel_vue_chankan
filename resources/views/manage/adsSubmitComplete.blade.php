@include("../components/head")
<body>
	<div id="app">
		<div class="wrap flex__wrap f__start input__area">
	        @include("../components/manage-sidebar")
			<div class="wrap__right">
	            @include("../components/manage-header")
				<div class="allWrapper">
					<div class="content__wrap">
						<div class="content__section">

							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">広告出稿仮登録完了</h1>
									<span class="en">Advertisement Provisional Registration Completed</span>
								</div>
							</div>

							<div class="content__floar">
								<div class="content__floar__inner">
									<div class="content__box">
										<div class="content__box__inner">
											<div class="content__text">
												<p>広告出稿最終契約用のURLを送信しました。</p>
												<p>先方が同意したタイミングで、出稿開始となります。</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="content__submit f__center">
							<div class="submit__box">
								<a href="{{ route('admin.advertisements.show', $id) }}">広告詳細へ</a>
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

