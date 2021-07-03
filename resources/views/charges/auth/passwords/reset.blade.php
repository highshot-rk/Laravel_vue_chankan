@include("../components/head")
<body>
    <div id="app">
    	<div class="wrap flex__wrap f_start">
    		<div class="wrap__center">
    			<div class="allWrapper">
    				<div class="content__wrap login s__wrap">
    					<div class="content__section">
                            @if ($errors->any())
                            <div class="content__error">
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
    						<div class="content__floar">
    							<div class="content__floar__inner">
    								<div class="content__box">
    									<div class="content__box__inner">
                                            <form method="POST" action="{{ route('charge.password.update') }}">
                                                @csrf
                                                <input type="hidden" name="token" value="{{ $token }}">

                                                <div class="content__input">
                                                    <div class="label">メールアドレス</div>
                                                    <div class="input__box">
                                                        <input type="email" class="borderType @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="label">パスワード</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="password" name="password" required>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="label">確認用パスワード</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="password" name="password_confirmation" required>
                                                    </div>
                                                </div>
                                                <div class="content__submit f__center">
                                                    <div class="submit__box">
                                                        <input class="clickonce" type="submit" value="パスワード再登録">
                                                    </div>
                                                </div>
                                            </form>
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
