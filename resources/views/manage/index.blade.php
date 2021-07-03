@include("../components/head")
<body>
    <div class="wrap flex__wrap f__start input__area f__center">
        <div class="wrap__center">
            <div class="allWrapper">
                <div class="content__wrap">
                    <div class="content__section">
                        <div class="content__header">
                            <div class="content__title">
                                <h1 class="h1">管理者画面</h1>
                                <span class="en">Manage Dashboard</span>
                            </div>
                        </div>
                        <div class="content__floar">
                            <div class="content__floar__inner">
                                <div class="content__box">
                                    <div class="content__box__inner">
                                        <div class="content__signal content__input">
                                            <ul class="flex__wrap">
                                                <li><a href="{{ route('admin.clients.add') }}">会員追加</a></li>
                                                <li><a href="{{ route('admin.advertisements.add') }}">広告会社追加</a></li>
                                            </ul>
                                        </div>
                                        <div class="content__input textCenter">
                                            <a href="{{ route('admin.logout') }}"
                                                class="textLink"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                ログアウト
                                            </a>
                                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
