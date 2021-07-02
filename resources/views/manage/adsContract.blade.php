@include("../components/head")
<body>
    <div id="app">
    	<div class="wrap flex__wrap f__start input__area">
    		{{-- @include("../components/manage-sidebar") --}}
    		<div class="wrap__center">
    			{{-- @include("../components/header") --}}
    			<div class="allWrapper">
                    <form action="{{ route('contracts.main_register') }}" method="POST">
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
                                        <h1 class="h1">契約最終確認</h1>
                                        <span class="en">Contract Final Confirmation</span>
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="{{ $contract->token }}">
                                <div class="content__floar">
                                    <div class="content__floar__inner">
                                        <div class="content__box">
                                            <div class="content__box__inner">
                                                <div class="content__input">
                                                    <div class="headline">会社名</div>
                                                    <div class="input__text">
                                                        <span>{{ $contract->advertisement->company }}</span>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline">URL</div>
                                                    <div class="input__text">
                                                        <span>{{ $contract->advertisement->url }}</span>
                                                    </div>
                                                </div>
                                                <div class="content__input">
                                                    <div class="headline">契約期間</div>
                                                    <div class="input__text">
                                                        <span>{{ $contract->period }}</span>
                                                    </div>
                                                </div>

                                                <div class="content__input">
                                                    <div class="headline">契約終了予定日</div>
                                                    <div class="input__text">
                                                        <span>{{ $contract->scheduleEndedAt() }}</span>
                                                    </div>
                                                </div>

                                                <div class="content__input">
                                                    <div class="headline">契約金額</div>
                                                    <div class="input__text">
                                                        <span>{{ $contract->priceWithUnit() }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="content__confirmation">
                                            <label class="checkbox__label"><a class="textLink" href="/terms/privacy/" target="_blank" rel="noopener">規約</a>に同意する
                                                <input type="checkbox" name="is_agreed" required>
                                                <div class="checkbox__block"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content__submit f__center">
                                <div class="submit__box">
                                    <input class="clickonce" type="submit" name="" value="契約する">
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