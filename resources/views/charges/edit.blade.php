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
                    <form @if ($isCharge) action="{{ route('charge.charges.update', $charge->id) }}" @else action="{{ route('charges.update', $charge->id) }}" @endif method="POST">
                        @csrf
                        <input type="hidden" name="charge_id" value="{{ $charge->id }}">
                        <div class="content__wrap">
                            <div class="content__section">

                                <div class="content__header">
                                    <div class="content__title">
                                        <h1 class="h1">スタッフ情報編集</h1>
                                        <span class="en">Charge Edit</span>
                                    </div>
                                </div>

                                {{-- バリデーションエラー時の表示 --}}
                                @if ($errors->any())
                                <div class="content__error" style="margin-top: 1em;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline attention must">スタッフの名前</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="name" value="{{ old('name', $charge->name) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">スタッフの電話番号</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="phone" value="{{ old('phone', $charge->phone) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">スタッフに与える権限</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box selectBox">
                                                            <select name="edit_type" class="bgType">
                                                                <option value="0" @if($charge->edit_type == 0) selected="selected" @endif>編集者</option>
                                                                <option value="1" @if($charge->edit_type == 1) selected="selected" @endif>閲覧者</option>
                                                            </select>
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
                                    <input class="clickonce" type="submit" name="" value="登録">
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
