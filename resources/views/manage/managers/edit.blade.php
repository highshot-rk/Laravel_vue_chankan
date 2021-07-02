@include("../components/head")
<body>
  <!-- スマホのみのメニューバー -->
  <div id="app">
      <div class="wrap flex__wrap f__start input__area">
        @include("../components/manage-sidebar")
        <div class="wrap__right">
          @include("../components/manage-header")
          <div class="allWrapper">
            <form action="{{ route('admin.managers.update', $manager->id) }}" method="POST">
                @csrf
                <div class="content__wrap">
                <div class="content__section">
                    {{-- 会員情報更新後のメッセージ表示 --}}
                    @if (session('message'))
                    <p>{{ session('message') }}</p>
                    @endif

                    <div class="content__header">
                    <div class="content__title">
                        <h1 class="h1">管理者編集</h1>
                        <span class="en">Manager Edit</span>
                    </div>
                    </div>

                    <div class="content__floar">
                    <div class="content__floar__inner">
                        <div class="content__box">
                            <div class="content__box__inner">
                                <div class="content__input">
                                <div class="headline attention must">お名前</div>
                                <div class="input__box">
                                    <input class="bgType" type="text" name="name" value="{{ old('name', $manager->name ) }}">
                                </div>
                                </div>
                                <div class="content__input">
                                <div class="headline attention must">メールアドレス</div>
                                <div class="input__wrap">
                                    <div class="input__box">
                                        <input class="bgType" type="email" name="email" value="{{ old('email', $manager->email ) }}">
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
                    <input class="clickonce" type="submit" name="" value="管理者情報更新">
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
