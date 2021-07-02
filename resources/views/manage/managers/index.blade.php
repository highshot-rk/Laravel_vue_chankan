@include("../components/head")
<body>
  <div id="app">
    <div class="wrap flex__wrap f__start">
      {{-- <div class="p__modal" v-on:class="{isOpen : isModalActive}">
        <div class="modal__inner">
          <div class="modal__content flex__wrap f__center v__center">
            <div class="modal__content__inner">
              <p class="attention">営業担当と元請けにメッセージが<br>送信されますが、よろしいでしょうか。</p>
              <ul class="selectTab flex__wrap">
                <li class="go"><a href="" title="">はい</a></li>
                <li class="back"><a href="" title="" v-bind:click="closeItem">戻る</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div> --}}
      @include("../components/manage-sidebar")
      <div class="wrap__right">
        @include("../components/manage-header")
        {{-- @include("../components/manage-header") --}}
        <div class="allWrapper">
          <div id="app">
          <div class="content__wrap">
            <div class="content__section">
              {{-- ユーザー情報更新後のメッセージ表示 --}}
              @if (session('message'))
              <p>{{ session('message') }}</p>
              @endif

              <div class="content__header">
                <div class="content__title">
                  <h1 class="h1">管理者一覧</h1>
                  <span class="en">Manager List</span>
                </div>
              </div>
              <!-- スマホ表示 -->
              <div class="tab">
                <admin-manager-index-sp-component :active-managers="{{ $activeManagers }}" :stopped-managers="{{ $stoppedManagers }}"></admin-manager-index-sp-component>
              </div>
              <div class="pc">

              <!-- PC表示 -->
                <admin-manager-index-pc-component :active-managers="{{ $activeManagers }}" :stopped-managers="{{ $stoppedManagers }}"></admin-manager-index-pc-component>
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
