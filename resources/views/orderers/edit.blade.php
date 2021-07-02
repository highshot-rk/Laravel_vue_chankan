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
                    <form @if ($isCharge) action="{{ route('charge.orderers.update', $projectOrderer->id) }}" @else action="{{ route('orderers.update', $projectOrderer->id) }}" @endif method="POST">
                        @csrf
                        <div class="content__wrap">
                            <div class="content__section">

                                @if (session('message'))
                                    @if ($isCharge)
                                    <script>
                                        alert('元請け情報を更新しました。');
                                        window.location.href = '/charge/orderers/detail/{{$projectOrderer->id}}';
                                    </script>
                                    @else
                                    <script>
                                        alert('元請け情報を更新しました。');
                                        window.location.href = '/orderers/detail/{{$projectOrderer->id}}';
                                    </script>
                                    @endif
                                @endif

                                <div class="content__header">
                                    <div class="content__title">
                                        <h1 class="h1">元請け情報編集</h1>
                                        <span class="en">Prime Contractor Edit</span>
                                    </div>
                                </div>

                                {{-- バリデーションエラー時の表示 --}}
                                @if ($errors->any())
                                <div class="content__error">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <!--
                                {{-- ユーザー情報更新後のメッセージ表示 --}}
                                @if (session('message'))
                                <div class="content__success">
                                    <p>{{ session('message') }}</p>
                                </div>
                                @endif
                                -->

                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline attention must">携帯電話（自動メッセージ送信先）</div>
                                                    <div class="input__box">
                                                        <input class="bgType" type="text" name="phone" value="{{ old('phone', $projectOrderer->phone) }}" required>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention must">会社名</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="company" value="{{ old('company', $projectOrderer->company) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">会社名（カナ）</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="company_kana" value="{{ old('company_kana', $projectOrderer->company_kana) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">郵便番号（※半角数字のみ入力可）</div>
                                                    <div class="input__wrap flex__wrap f__start v__center">
                                                        <div class="input__box post__one">
                                                            <input class="bgType" type="text" name="zip_first" placeholder="000" value="{{ old('zip_first', $zip_first) }}">
                                                        </div>
                                                        -
                                                        <div class="input__box post__two">
                                                            <input class="bgType" type="text" name="zip_second" placeholder="0000" value="{{ old('zip_second', $zip_second) }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="content__input">
                                                    <div class="headline attention any">住所</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="address" value="{{ old('address', $projectOrderer->address) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">代表者名</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="president" value="{{ old('remark', $projectOrderer->president) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">代表者名（カナ）</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="president_kana" value="{{ old('remark', $projectOrderer->president_kana) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">メールアドレス</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="email" name="email" value="{{ old('email', $projectOrderer->email) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">電話番号</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="tel" value="{{ old('tel', $projectOrderer->tel) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">ファックス</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <input class="bgType" type="text" name="fax" value="{{ old('fax', $projectOrderer->fax) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline attention any">備考</div>
                                                    <div class="input__wrap">
                                                        <div class="input__box">
                                                            <textarea class="bgType remark" name="remark">{{ old('remark', $projectOrderer->remark) }}</textarea>
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
