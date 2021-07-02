<div class="wrap__left">
    <div class="wrap__left__inner">
      <div id="close__button" class="sp">
        <img src="{{ asset('assets//img/icon_batu_black.png') }}">
      </div>
      <div class="wrap__left__logo pc">
        <img src="{{ asset('assets/img/logo.png') }}">
      </div>
      <ul>
        <li><a href="{{ route('admin.clients.index') }}"><img src="{{ asset('assets/img/icon_human_black.png') }}">会員一覧</a></li>
        <li><a href="{{ route('admin.clients.add') }}"><img src="{{ asset('assets/img/icon_people_add_black.png') }}">会員追加</a></li>
        <li><a href="{{ route('admin.advertisements.index') }}"><img src="{{ asset('assets/img/icon_company_list_black.png') }}">広告出稿一覧</a></li>
        <li><a href="{{ route('admin.advertisements.add') }}"><img src="{{ asset('assets/img/icon_company_black.png') }}">広告出稿追加</a></li>
        <li><a href="{{ route('admin.managers.index') }}"><img src="{{ asset('assets/img/icon_human_black.png') }}">管理者一覧</a></li>
        <li><a href="{{ route('admin.managers.add') }}"><img src="{{ asset('assets/img/icon_people_add_black.png') }}">管理者追加</a></li>
        <li><a href="{{ route('admin.smss.index') }}"><img src="{{ asset('assets/img/icon_sms_two_black.png') }}">SMS利用状況</a></li>
          <li>
              <a href="{{ route('admin.logout') }}"
                  onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                  <img src="{{ asset('assets/img/icon_goout_black.png') }}">
                  ログアウト
              </a>
          </li>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
      </ul>
    </div>
  </div>

