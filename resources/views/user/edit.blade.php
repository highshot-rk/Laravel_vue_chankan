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
                    <form @if ($isCharge) action="{{ route('charge.user.update') }}" @else action="{{ route('user.update') }}" @endif method="POST">
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

                                @if (session('message'))
                                    @if ($isCharge)
                                    <script>
                                        alert('ユーザー情報を更新しました。');
                                        window.location.href = '/charge/user';
                                    </script>
                                    @else
                                    <script>
                                        alert('ユーザー情報を更新しました。');
                                        window.location.href = '/user';
                                    </script>
                                    @endif
                                @endif

                                <!--
                                {{-- ユーザー情報更新後のメッセージ表示 --}}
                                @if (session('message'))
                                <p>{{ session('message') }}</p>
                                @endif
                                -->

                                <div class="content__header">
                                    <div class="content__title">
                                        <h1 class="h1">ユーザー情報編集</h1>
                                        <span class="en">User Edit</span>
                                    </div>
                                </div>

                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            {{-- 担当者でログインしている場合の表示 --}}
                                            @if ($isCharge)
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline attention must">お名前</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="name"
                                                            value="{{ old('name', $loginCharge->name) }}">
                                                    </div>
                                                </div>
                                                {{--  <div class="content__input">
                                                    <div class="headline attention must">メールドレス</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="email" name="email"
                                                            value="{{ old('email', $loginCharge->email) }}">
                                                    </div>
                                                </div>  --}}
                                                <div class="content__input">
                                                    <div class="headline attention must">携帯番号（ハイフン不要）</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="phone"
                                                            value="{{ old('phone', $loginCharge->phone) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            {{-- ユーザーでログインしている場合の表示 --}}
                                            <div class="content__box__inner">
                                                {{-- <div class="content__input">
                                                    <div class="headline attention must">担当者名</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="name"
                                                            value="{{ old('name', $user->name) }}">
                                                    </div>
                                                    <div class="input__box addList">
                                                        <input class="bgType" type="text" name="name"
                                                            value="{{ old('name', $user->name) }}">
                                                    </div>
                                                    <p class="otherLinkText">担当者の追加希望は<a href="mailto:" class="textLink">コチラ</a></p>
                                                </div> --}}
                                                <div class="content__input">
                                                    <div class="headline attention must">お名前</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="name"
                                                            value="{{ old('name', $user->name) }}">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">メールドレス</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="email" name="email"
                                                            value="{{ old('email', $user->email) }}">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">会社名（屋号）</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="company"
                                                            value="{{ old('company', $user->company) }}">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">代表者の電話番号（ハイフン不要）</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="phone"
                                                            value="{{ old('phone', $user->phone) }}">
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">都道府県</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box selectBox">
                                                            <select class="bgType" name="prefecture_id">
                                                                @foreach ($prefectures as $prefecture)
                                                                <option value="{{ $prefecture->id }}" @if (old('prefecture_id',
                                                                    $user->prefecture_id) == $prefecture->id) selected @endif>
                                                                    {{ $prefecture->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--
                                                @foreach ($user->charges as $charge)
                                                <input type="hidden" name="charge[{{ $loop->iteration - 1 }}][id]" value="{{ $charge->id }}">
                                                <div class="content__input">
                                                    <div class="content__input__box">
                                                        <div class="headline attention must">担当者名{{ $loop->iteration }}</div>
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="charge[{{ $loop->iteration - 1 }}][name]"
                                                                value="{{ old('charge.'.($loop->iteration - 1).'.name', $charge->name) }}">
                                                        </div>
                                                    </div>
                                                    <div class="content__input__box">
                                                        <div class="headline attention must">担当者名{{ $loop->iteration }}メールアドレス</div>
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="charge[{{ $loop->iteration - 1 }}][email]"
                                                            value="{{ old('charge.'.($loop->iteration - 1).'.email', $charge->email) }}">
                                                        </div>
                                                    </div>
                                                    <div class="content__input__box">
                                                        <div class="headline attention must">担当者名{{ $loop->iteration }}タイプ</div>
                                                        <div class="input__box selectBox">
                                                            <select class="bgType" name="charge[{{ $loop->iteration - 1 }}][edit_type]">
                                                                <option value="0"
                                                                    @if ((old('charge.'.($loop->iteration - 1).'.name', $charge->edit_type)) == 0) selected @endif>編集者</option>
                                                                <option value="1"
                                                                    @if ((old('charge.'.($loop->iteration - 1).'.name', $charge->edit_type)) == 1) selected @endif>閲覧者</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="content__input__box">
                                                        <div class="headline attention must">担当者{{ $loop->iteration }}携帯番号（ハイフン不要）</div>
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="charge[{{ $loop->iteration - 1}}][phone]"
                                                                value="{{ old('charge.'.($loop->iteration - 1).'.phone', $charge->phone) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="content__input">
                                                    <p class="otherLinkText textCenter"><a href="mailto:56@zotman.jp?subject=%E6%8B%85%E5%BD%93%E8%80%85%E8%BF%BD%E5%8A%A0%E3%81%AE%E4%BB%B6&amp;body=%E6%8B%85%E5%BD%93%E8%80%85%E3%82%92%E8%BF%BD%E5%8A%A0%E3%81%99%E3%82%8B%E6%96%B9%E3%81%AE%E3%81%8A%E5%90%8D%E5%89%8D%E3%82%92%E8%A8%98%E8%BC%89%E3%81%97%E3%81%A6%E3%81%8F%E3%81%A0%E3%81%95%E3%81%84%E3%80%821%E5%90%8D%E8%BF%BD%E5%8A%A0%E3%81%94%E3%81%A8%E3%81%AB%E6%9C%88%E9%A1%8D%E5%88%A9%E7%94%A8%E6%96%991%E4%B8%87%E5%86%86%E8%BF%BD%E5%8A%A0%E3%81%AB%E3%81%AA%E3%82%8A%E3%81%BE%E3%81%99%E3%80%82%E9%80%81%E4%BF%A1%E5%BE%8C%E3%80%81%E6%B1%BA%E6%B8%88URL%E3%82%92%E3%81%8A%E9%80%81%E3%82%8A%E3%81%97%E3%81%BE%E3%81%99%E3%81%AE%E3%81%A7%E3%80%81%E6%B1%BA%E6%B8%88%E3%82%92%E8%A1%8C%E3%81%A3%E3%81%A6%E3%81%8F%E3%81%A0%E3%81%95%E3%81%84%E3%80%82&amp;" class="textLink">担当者の追加希望はコチラ</a></p>
                                                </div>
                                                --}}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="content__submit f__center">
                                    <div class="submit__box">
                                        <input class="clickonce" type="submit" name="" value="ユーザー情報編集">
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
