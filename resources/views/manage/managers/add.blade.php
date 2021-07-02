@include("../components/head")
<body id="manageBody">
    <div id="app">
        <div class="wrap flex__wrap f__start input__area">
            @include("../components/manage-sidebar")
            <div class="wrap__right">
              @include("../components/manage-header")
              <div class="allWrapper">
                <form action="{{ route('admin.managers.register') }}" method="POST">
                    @csrf
                    <div class="content__wrap">
                    <div class="content__section">

                        <div class="content__header">
                            {{-- バリデーションエラー時の表示 --}}
                            @if ($errors->any())
                            <div class="alert alert-danger content__error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="content__title">
                                <h1 class="h1">管理者新規登録</h1>
                                <span class="en">Manager Register</span>
                            </div>
                        </div>

                        <div class="content__floar">
                        <div class="content__floar__inner">
                            <div class="content__box">
                            <form action="{{ route('admin.managers.register') }}" method="POST">
                                @csrf
                                <div class="content__box__inner">
                                    <div class="content__input">
                                    <div class="headline attention must">お名前</div>
                                    <div class="input__box">
                                        <input class="bgType" type="text" name="name" value="{{ old('name') }}">
                                    </div>
                                    </div>
                                    <div class="content__input">
                                    <div class="headline attention must">メールアドレス</div>
                                    <div class="input__wrap">
                                        <div class="input__box">
                                        <input class="bgType" type="email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="content__input">
                                        <div class="headline attention must">パスワード</div>
                                        <div class="input__wrap">
                                            <div class="input__box">
                                            <input class="bgType" type="password" name="password" value="{{ old('password') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="content__submit f__center">
                        <div class="submit__box">
                        <input class="clickonce" type="submit" name="" value="管理者登録">
                        </div>
                    </div>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
