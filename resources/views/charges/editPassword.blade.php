@include("../components/head")
<body>
    <div id="app">
        <!-- スマホのみのメニューバー -->
        <?php if (is_mobile()) { ?>
            @include("../components/nav")
        <?php } ?>
        </body>
        <div class="wrap flex__wrap f__start input__area">
            @include("../components/sidebar")
            <div class="wrap__right">
                @include("../components/header")
                <div class="allWrapper">
                    <form action="{{ route('charges.update_password', $id) }}" method="POST">
                        @csrf
                        <div class="content__wrap">
                            <div class="content__section">

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

                                <div class="content__header">
                                    <div class="content__title">
                                        <h1 class="h1">担当者のパスワードを変更する</h1>
                                        <span class="en">Password Edit</span>
                                    </div>
                                </div>

                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline attention must">新しいパスワード</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="password" name="password">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">新しいパスワード再入力</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="password" name="password_confirm">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content__submit f__center">
                                <div class="submit__box">
                                    <input class="clickonce" type="submit" name="" value="パスワード再登録">
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
