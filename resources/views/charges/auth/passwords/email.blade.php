@include("../components/head")
<body>
	<div id="app">
		<div class="wrap flex__wrap f_start">
			<div class="wrap__center">
				<div class="allWrapper">
					<div class="content__wrap login s__wrap">
						<div class="content__section">
							@if (session('status'))
							<div class="content__success alert" role="alert">
							    <p>{{ session('status') }}</p>
							</div>
							@endif
							<div class="content__floar">
								<div class="content__floar__inner">
									<div class="content__box">
                                        <form method="POST" action="{{ route('charge.password.email') }}">
                                            @csrf
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="label">メールアドレス</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="text" name="email">
                                                    </div>
                                                </div>
                                                <div class="content__submit f__center">
                                                    <div class="submit__box">
                                                        <input class="clickonce" type="submit" value="パスワード再設定">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
									</div>
								</div>
							</div>
							<div class="login__link prev">
								<ul>
									<li class="prev"><a class="bgCenterCover" href="{{ route('charge.login') }}">ログイン画面へ戻る</a></li>
								</ul>
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
