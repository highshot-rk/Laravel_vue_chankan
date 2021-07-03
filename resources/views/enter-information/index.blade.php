@include("../components/head")
<body>
    <div id="app">
        {{-- <div class="modal__term">
            <div class="allWrapper flex__wrap">
                <div class="modal__term__field">
                    <div class="returnButton">
                        <span class="f__center">
                            <img src="{{ asset('assets/img/icon_batu_white.png') }}" alt="">
                        </span>
                    </div>
                    <div class="term__text">
                        <p>ここに規約。ここに規約。ここに規約。ここに規約。</p>
                        <p>ここに規約。ここに規約。ここに規約。ここに規約。</p>
                        <p>ここに規約。ここに規約。ここに規約。ここに規約。</p>
                        <p>ここに規約。ここに規約。ここに規約。ここに規約。</p>
                        <p>ここに規約。ここに規約。ここに規約。ここに規約。</p>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="wrap flex__wrap f__start input__area">
            <div class="wrap__center">
                <div class="allWrapper">
                    <form action="{{ route('user.main_register') }}" method="POST">
                        @csrf
                        <div class="content__wrap">
                            <div class="content__section">
                                {{-- バリデーションエラー時の表示 --}}
                                @if ($errors->any())
                                <div class="alert content__error">
                                    @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                                @endif
                                <div class="content__header">
                                    <div class="content__title">
                                        <p class="textCenter">基本情報のご登録をお願いいたします。</p>
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline attention must">お名前</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="text" name="name" value="{{ old('name') }}" required>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">パスワード（5文字以上）</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="password" name="password" required>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">会社名（屋号）</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="text" name="company" value="{{ old('company') }}">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">代表者の携帯番号</div>
                                                    <div class="input__box">
                                                        <input class="borderType" type="text" name="phone" value="{{ old('phone') }}" required>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">都道府県</div>
                                                    <div class="input__box selectBox">
                                                        <select class="bgType" name="prefecture_id" required>
                                                            @foreach ($prefectures as $prefecture)
                                                            <option
                                                                value="{{ $prefecture->id }}"
                                                                @if (old('prefecture_id') == $prefecture->id) selected @endif>
                                                                {{ $prefecture->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                {{--  @foreach ($user->charges as $charge)
                                                    <input type="hidden" name="charges[{{ $loop->iteration - 1 }}][id]" value="{{ $charge->id }}">
                                                    <div class="content__input">
                                                        <div class="headline attention must">カレンダー共有する担当者{{ $loop->iteration }}</div>
                                                        <div class="input__box">
                                                            <input class="borderType" type="text" name="charges[{{ $loop->iteration - 1 }}][name]" value="{{ old('charges'.($loop->iteration - 1) .'name', $charge->name) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="content__input">
                                                        <div class="headline attention must">カレンダー共有する担当者携帯番号{{ $loop->iteration }}</div>
                                                        <div class="input__box">
                                                            <input class="borderType" type="text" name="charges[{{ $loop->iteration - 1 }}][phone]" value="{{ old('charges.'.($loop->iteration - 1) .'.phone', $charge->phone) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="content__input">
                                                        <div class="headline attention must">カレンダー共有する担当者メールアドレス</div>
                                                        <div class="input__box">
                                                            <input class="borderType" type="text" name="charges[{{ $loop->iteration - 1 }}][email]" value="{{ old('charges'.($loop->iteration - 1) .'email', $charge->email) }}">
                                                        </div>
                                                    </div>
                                                    <div class="content__input">
                                                        <div class="headline attention must">カレンダー共有する担当者パスワード</div>
                                                        <div class="input__box">
                                                            <input class="borderType" type="password" name="charges[{{ $loop->iteration - 1 }}][password]" value="{{ old('charges'.($loop->iteration - 1) .'password') }}">
                                                        </div>
                                                    </div>
                                                    <div class="content__input">
                                                        <div class="headline attention must">カレンダー共有する担当者タイプ</div>
                                                        <div class="input__box selectBox">
                                                            <select class="bgType" name="charges[{{ $loop->iteration - 1 }}][edit_type]" value="{{ old('charges'.($loop->iteration - 1) .'edit_type', $charge->edit_type) }}">
                                                                <option value="0" @if (old('charges'.($loop->iteration - 1) .'edit_type', $charge->edit_type) == 0) selected @endif>編集者</option>
                                                                <option value="1" @if (old('charges'.($loop->iteration - 1) .'edit_type', $charge->edit_type) == 1) selected @endif>閲覧者</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endforeach  --}}
                                                <div class="content__confirmation">
                                                    <label class="checkbox__label">
                                                        <a href="/terms/privacy" class="textLink" target="_blank" rel="noopener">規約</a>に同意する
                                                        <input type="checkbox" name="is_agreed" required>
                                                        <div class="checkbox__block"></div>
                                                    </label>
                                                </div>
                                                <div class="content__submit f__center">
                                                    <div class="submit__box">
                                                        <input class="clickonce" type="submit" name="" value="登録">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
