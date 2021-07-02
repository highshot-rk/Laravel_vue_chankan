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
								<div class="content__error"></div>
								<div class="content__box">
									<div class="content__box__inner">
										<div class="content__input">
											<div class="label">パスワード</div>
											<div class="input__box">
												<input class="borderType" type="" name="">
											</div>
										</div>
										<div class="content__input">
											<div class="label">確認用パスワード</div>
											<div class="input__box">
												<input class="borderType" type="" name="">
											</div>
										</div>
										<div class="content__submit f__center">
											<div class="submit__box">
												<input class="clickonce" type="submit" name="" value="パスワード再登録">
											</div>
										</div>
									</div>
								</div>
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
