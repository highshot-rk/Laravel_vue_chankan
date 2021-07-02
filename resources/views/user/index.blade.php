@include("../components/head")
<body>
	<div id="app">
		@include("../components/nav")
		<div class="wrap flex__wrap f__start input__area">
	        @include("../components/sidebar")
			<div class="wrap__right">
	            @include("../components/header")
				<div class="allWrapper">
					<div class="content__wrap">
						<div class="content__section">

							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">会員情報詳細</h1>
									<span class="en">User Detail</span>
								</div>
								<div class="content__edit">
									<ul class="flex__wrap f__start">
										<li><a @if ($isCharge) href="{{ route('charge.user.edit') }}" @else href="{{ route('user.edit') }}" @endif>編集</a></li>
									</ul>
								</div>
							</div>

                            @if ($isCharge)
							<div class="content__floar">
								<div class="content__floar__inner">
									<div class="content__box">
										<div class="content__box__inner">
											<div class="content__input">
												<div class="headline">担当者名</div>
												<div class="input__text">
	                                                <span>{{ $loginCharge->name }}</span><br>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">担当者メールアドレス</div>
												<div class="input__text">
	                                                <span>{{ $loginCharge->email }}</span><br>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">担当者携帯電話</div>
												<div class="input__text">
	                                                <span>{{ $loginCharge->phone }}</span><br>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">パスワード</div>
												<div class="input__text">
													<a class="textLink" @if ($isCharge) href="{{ route('charge.user.edit_password') }}" @else href="{{ route('user.edit_password') }}" @endif title="">パスワード変更はコチラ</a>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">会社名（屋号）</div>
												<div class="input__text">
													<span>{{ $user->company }}</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">都道府県</div>
												<div class="input__text">
													<span>{{ $user->prefecture->name }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
                            @else
							<div class="content__floar">
								<div class="content__floar__inner">
									<div class="content__box">
										<div class="content__box__inner">
											<div class="content__input">
												<div class="headline">担当者名</div>
												<div class="input__text">
													<span>@foreach ($user->charges as $charge){{ $charge->name }}<br>@endforeach</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">担当者メールアドレス</div>
												<div class="input__text">
													<span>@foreach ($user->charges as $charge){{ $charge->email }}<br>@endforeach</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">担当者携帯電話</div>
												<div class="input__text">
													<span>@foreach ($user->charges as $charge){{ $charge->phone }}<br>@endforeach</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">担当者タイプ</div>
												<div class="input__text">
													<span>@foreach ($user->charges as $charge){{ $charge->editType() }}<br>@endforeach</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">パスワード</div>
												<div class="input__text">
													<a class="textLink" @if ($isCharge) href="{{ route('charge.user.edit_password') }}" @else href="{{ route('user.edit_password') }}" @endif title="">パスワード変更はコチラ</a>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">会社名（屋号）</div>
												<div class="input__text">
													<span>{{ $user->company }}</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">メールアドレス</div>
												<div class="input__text">
													<span>{{ $user->email }}</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">代表者の電話番号</div>
												<div class="input__text">
													<span>{{ $user->phone }}</span>
												</div>
											</div>
											<div class="content__input">
												<div class="headline">都道府県</div>
												<div class="input__text">
													<span>{{ $user->prefecture->name }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
                            </div>
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    @include("../components/footer")
</body>
</html>
