<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title></title>
  <meta name="description" content="" />
  <link rel="stylesheet" type="text/css" href="style.css">

  <?php if (is_mobile()) { ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/mobile.css') }}">
  <?php } else { ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pc.css') }}">
  <?php } ?>

  <!-- favicon -->
  <link rel="icon" href="" sizes="16x16" type="image/png" />
  <link rel="icon" href="" sizes="32x32" type="image/png" />
  <link rel="icon" href="" sizes="48x48" type="image/png" />
  <link rel="icon" href="" sizes="62x62" type="image/png" />
    <link rel="shortcut icon" href="" type="image/x-icon" />
</head>
<body>
  <!-- スマホのみのメニューバー -->
  <?php if (is_mobile()) { ?>
    <nav class="sp commonShadow">
      <div class="allWrapper">
        <ul class="flex__wrap">
          <li><a href="" class="f__center"><img src="{{ asset('assets/img/icon_calender_black.png') }}"></a></li>
          <li><a href="" class="f__center"><img src="{{ asset('assets/img/icon_nav_menu.png') }}"></a></li>
        </ul>
        <div class="plusButton">
          <a href="" class="f__center"><img src="{{ asset('assets/img/icon_add_black.png') }}"></a>
        </div>
      </div>
    </nav>

  <?php } ?>
  <div class="wrap flex__wrap f__start input__area">
    <div class="wrap__left">
      <div class="wrap__left__inner">
        <div id="close__button" class="sp">
          <img src="{{ asset('assets//img/icon_batu_black.png') }}" alt="">
        </div>
        <div class="wrap__left__logo pc">
          <img src="{{ asset('assets/img/logo.png') }}" alt="">
        </div>
        <ul>
          <li><a href="" title=""><img src="{{ asset('assets/img/icon_calender_black.png') }}" alt="">カレンダー</a></li>
          <li><a href="" title=""><img src="{{ asset('assets/img/icon_human_black.png') }}" alt="">元請け一覧</a></li>
          <li><a href="" title=""><img src="{{ asset('assets/img/icon_profile_black.png') }}" alt="">プロフィール編集</a></li>
          <li><a href="" title=""><img src="{{ asset('assets/img/icon_term_black.png') }}" alt="">規約</a></li>
          <li><a href="" title=""><img src="{{ asset('assets/img/icon_mail_black.png') }}" alt="">運営へお問い合わせ</a></li>
        </ul>
      </div>
    </div>



    <div class="wrap__right">
      <header id="header" class="">
        <?php if (is_mobile()) { ?>
          <div class="allWrapper flex__wrap">
            <div class="header__left">
              <div class="arrow">
                <img src="{{ asset('assets/img/icon_arrow_left_black.png') }}" alt="">
              </div>
            </div>
            <div class="header__center">
              <div class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
              </div>
            </div>
            <div class="header__right">
              <div class="search f__center commonShadow">
                <img src="{{ asset('assets/img/icon_header_search_black.png') }}" alt="">
              </div>
            </div>
          </div>
        <?php } else { ?>
          <div class="allWrapper">
            <div class="search__input flex__wrap f__end">
              <div class="search__input__inner flex__wrap f__end">
                <div class="box keyword"><input type="text" name="" placeholder="ここにキーワードを入れる"></div>
                <div class="box charge selectBox"><input type="text" name="" placeholder="担当者名"></div>
                <div class="box submit bgCenterCover"><input class="clickonce" type="submit" name=""></div>
              </div>
            </div>
          </div>
        <?php } ?>
      </header><!-- /header -->


      <div class="allWrapper">
        <div class="content__wrap">
          <div class="content__section">

            <div class="content__header">
              <div class="content__title">
                <h1 class="h1">新規架設登録完了</h1>
                <span class="en">New Registration Completed</span>
              </div>
            </div>

            <div class="content__floar">
              <div class="content__floar__inner">
                <div class="content__box">
                  <div class="content__box__inner">
                    <div class="content__text">
                      <p>新規架設の登録が完了しました。</p>
                      <p>詳細ページより、案件情報をスタッフに送信しましょう。</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content__submit f__center">
            <div class="submit__box">
              <a href="">案件詳細ページへ</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
