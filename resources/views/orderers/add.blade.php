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
                    <form @if ($isCharge) action="{{ route('charge.orderers.store') }}" @else action="{{ route('orderers.store') }}" @endif method="POST">
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
                                        <h1 class="h1">元請け新規登録</h1>
                                        <span class="en">Prime Contractor Register</span>
                                    </div>
                                </div>

                            <div class="content__floar">
                                <div class="content__floar__inner">
                                    <div class="content__box">
                                        <div class="content__box__inner">
                                            <div class="content__input">
                                                <div class="headline attention must">携帯電話（自動メッセージ送信先）</div>
                                                <div class="input__box">
                                                    <input class="bgType" type="text" name="phone" value="{{ old('phone') }}">
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention must">会社名</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="company" value="{{ old('company') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">会社名（カナ）</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="company_kana" value="{{ old('company_kana') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">郵便番号（※半角数字のみ入力可）</div>
                                                <div class="input__wrap flex__wrap f__start v__center">
                                                    <div class="input__box post__one">
                                                        <input class="bgType" type="text" name="zip_first" placeholder="000" value="{{ old('zip_first') }}">
                                                    </div>
                                                    -
                                                    <div class="input__box post__two">
                                                        <input class="bgType" type="text" name="zip_second" placeholder="0000" value="{{ old('zip_second') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">住所</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="address" value="{{ old('address') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">代表者名</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="president" value="{{ old('president') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">代表者名（カナ）</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="president_kana" value="{{ old('president_kana') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">メールアドレス</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="email" name="email" value="{{ old('email') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">電話番号</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="tel" value="{{ old('tel') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">ファックス</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="fax" value="{{ old('fax') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content__input">
                                                <div class="headline attention any">備考</div>
                                                <div class="input__wrap">
                                                    <div class="input__box">
                                                        <textarea class="bgType remark" name="remark">{{ old('remark') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content__submit f__center">
                                <div class="submit__box">
                                    <input class="clickonce" type="submit" name="" value="元請け登録">
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
