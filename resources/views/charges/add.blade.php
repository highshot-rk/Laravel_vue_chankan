@include("../components/head")
<body>
    <div id="app">
        <!-- スマホのみのメニューバー -->
        @include("../components/nav")
        <div class="wrap flex__wrap f__start input__area">
            @include("../components/sidebar")
            <div class="wrap__right">
                @include("../components/header")
                <div class="allWrapper">
                    <form @if ($isCharge) action="{{ route('charge.charges.store') }}" @else action="{{ route('charges.store') }}" @endif method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user_id }}">

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
                                    <h1 class="h1">スタッフ新規登録</h1>
                                    <span class="en">Charge Register</span>
                                </div>
                            </div>
                            <div class="content__floar">
                                <div class="content__floar__inner">
                                    <div class="content__box">
                                        <div class="content__box__inner">
                                            <div class="content__input">
                                                <div class="headline attention must">スタッフの名前</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="name" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention must">スタッフ専用のパスワード（8文字以上）</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="password" name="password" value="{{ old('password') }}" required onInput="checkForm(this)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention must">スタッフの電話番号</div>
                                                <div class="input__box">
                                                    <input class="bgType" type="number" name="phone" value="{{ old('phone') }}" required>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention must">スタッフに与える権限</div>
                                                <div class="input__wrap">
                                                    <div class="input__box selectBox">
                                                        <select class="bgType" name="edit_type" required>
                                                            <option value="0" @if(old('edit_type') == 0) selected @endif>編集者</option>
                                                            <option value="1" @if(old('edit_type') == 1) selected @endif>閲覧者</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <p style="margin-top: 2em;">閲覧者は一切の編集はできません。閲覧のみ可能になります。</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content__submit f__center">
                                <div class="submit__box">
                                    <input class="clickonce" type="submit" value="担当者登録">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
    </div>
    //
    <script>
        function checkForm($this) {
            var str=$this.value;
            while(str.match(/[^A-Z^a-z\d\-]/))
            {
                str=str.replace(/[^A-Z^a-z\d\-]/,"");
            }
            $this.value=str;
        }
    </script>
	@include("../components/footer")
</body>
</html>
