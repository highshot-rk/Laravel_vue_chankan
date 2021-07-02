
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
										<div class="content__input">
											<div class="label">メールアドレス</div>
											<div class="input__box">
												<input class="borderType" type="" name="">
											</div>
										</div>
										<div class="content__submit f__center">
											<div class="submit__box">
												<input class="clickonce" type="submit" name="" value="パスワード再設定">
											</div>
										</div>
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
