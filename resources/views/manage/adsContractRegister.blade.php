@include("../components/head")
<body>
    <div id="app">
        <div class="wrap flex__wrap f__start input__area">
            @include("../components/manage-sidebar")
            <div class="wrap__right">
                @include("../components/manage-header")
                <div class="allWrapper">
                    <form action="{{ route('admin.contracts.register', $id) }}" method="POST">
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
                                        <h1 class="h1">広告出稿</h1>
                                        <span class="en">Add Register</span>
                                    </div>
                                </div>

                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline">契約期間</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box selectBox">
                                                            <select class="bgType" name="period">
                                                                <option value="1ヶ月" @if (old('period') == '1ヶ月') selected @endif>1ヶ月</option>
                                                                <option value="3ヶ月" @if (old('period') == '3ヶ月') selected @endif>3ヶ月</option>
                                                                <option value="6ヶ月" @if (old('period') == '6ヶ月') selected @endif>6ヶ月</option>
                                                                <option value="12ヶ月" @if (old('period') == '12ヶ月') selected @endif>12ヶ月</option>
                                                            </select>
                                                            {{--                                                     <select class="bgType" name="prefecture_id">
                                                            @foreach ($prefectures as $prefecture)
                                                            <option value="{{ $prefecture->id }}" @if (old('prefecture_id',
                                                                $user->prefecture_id) == $prefecture->id) selected @endif>
                                                                {{ $prefecture->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline">金額</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="price" value="{{ old('price') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content__submit f__center">
                                <div class="submit__box">
                                    <input class="clickonce" type="submit" name="" value="広告出稿">
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
