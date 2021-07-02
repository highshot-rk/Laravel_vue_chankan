{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary clickonce">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@include("../components/head")
<body>
    <div id="app">
	<!-- スマホのみのメニューバー -->
	{{-- @include("../components/header") --}}
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
    {{-- 
                                    @if ($errors->any())
    								<div class="content__error">
                                        <ul class="alartBlue">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif --}}
    								<div class="content__box">
    									<div class="content__box__inner">
                                            <form method="POST" action="{{ route('password.update') }}">
                                                @csrf
                                                <input type="hidden" name="token" value="{{ $token }}">

                                                <div class="content__input">
                                                    <div class="label">メールアドレス</div>
                                                    <div class="input__box">
                                                        <input type="email" class="borderType @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                                    </div>
                                                    {{-- @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror --}}
                                                </div>
                                                <div class="content__input">
                                                    <div class="label">パスワード</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="password" name="password" required>
                                                    </div>
                                                    {{-- @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror --}}
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
