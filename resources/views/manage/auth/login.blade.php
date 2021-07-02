@include("../components/head")

<body>
    <!-- スマホのみのメニューバー -->
    {{-- @include("../components/header") --}}
    <div id="app">
        <div class="wrap flex__wrap f_start">
            <div class="wrap__center">
                <div class="allWrapper">
                    <div class="content__wrap login s__wrap">
                        <div class="content__section">

                            {{-- バリデーションエラー時の表示 --}}
                            @if ($errors->any())
                            <div class="content__error alert">
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif

                            <div class="content__floar">
                                <div class="content__floar__inner">
                                    <div class="content__box">
                                        <form action="{{ route('admin.login') }}" method="POST">
                                            @csrf
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="label">メールアドレス</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="text" name="email">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="label">パスワード</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="password" name="password">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="rememberCheckbox">
                                                        <label>
                                                            <input type="checkbox" name="remember">
                                                            <span>ログイン状態を保持する</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="resetPassword">
                                                    <a class="textLink"
                                                        href="{{ route('admin.password.request') }}">パスワードをお忘れの方へ</a>
                                                </div>
                                                <div class="content__submit f__center">
                                                    <div class="submit__box">
                                                        <input class="clickonce" type="submit" value="ログイン">
                                                    </div>
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
    @include("../components/footer")
</body>

</html>