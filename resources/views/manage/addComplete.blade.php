@include("../components/head")
<body>
  <div id="app">
    <div class="wrap flex__wrap f__start input__area">
      @include("../components/manage-sidebar")
      <div class="wrap__right">
        @include("../components/manage-header")

        <div class="allWrapper">
          <div class="content__wrap">
            <div class="content__section">

              <div class="content__header">
                <div class="content__title">
                  <h1 class="h1">会員登録完了</h1>
                  <span class="en">User Registration Completed</span>
                </div>
              </div>

              <div class="content__floar">
                <div class="content__floar__inner">
                  <div class="content__box">
                    <div class="content__box__inner">
                      <div class="content__text">
                        <p>会員新規登録が完了しました。</p>
                        <p>登録したメールアドレスに、<br class="sp">招待用のメールをお送りしました。</p>
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
  </div>
</body>
</html>
