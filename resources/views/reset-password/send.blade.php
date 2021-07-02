
	@include("../components/head")
<body>
	<!-- スマホのみのメニューバー -->
	@include("../components/header")
	<div class="wrap flex__wrap f_start">
		<div class="wrap__right">
			<div class="allWrapper">
				<div class="content__wrap login s__wrap">
					<div class="content__section">
						<div class="content__floar">
							<div class="content__floar__inner">
								<div class="content__box">
									<div class="content__box__inner">
										<div class="content__text">
											<p>パスワードの再設定用URLを、入力いただいたメールアドレスに送信しました。</p>
											<p>1時間以内にお手続きを進めないと破棄されますので、ご注意くださいませ。</p>
										</div>
								</div>
							</div>
						</div>
						<div class="login__link prev">
							<ul>
								<li class="prev"><a class="bgCenterCover" href="">ログイン画面へ戻る</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
