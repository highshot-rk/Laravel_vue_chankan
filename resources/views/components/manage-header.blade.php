<header id="header" class="tab">
	<div class="allWrapper">
		<div class="header__inner flex__wrap f__center">
			<div class="header__left">
				<div class="arrow" onclick="javascript:window.history.back(-1);return false;">
					<img src="{{ asset('assets/img/icon_arrow_left_black.png') }}">
				</div>
			</div>
			<div class="header__center">
				<div class="logo">
					<img src="{{ asset('assets/img/logo.png') }}">
				</div>
			</div>
			<div class="header__right">
				<div id="opneMenu" class="manageMenu f__center commonShadow" v-on:click="toggleItem">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
		</div>
	</div>

	<div class="menuTable" :class="{'isOpen': isMenuModal}">
	  <div class="allWrapper">
	    <div class="modal__inner">
	    	<div class="closeMenu" v-on:click="closeItem"><img src="{{ asset('assets/img/icon_batu_black.png') }}"></div>
	      <ul>
	        <li><a href="{{ route('admin.clients.index') }}"><img src="{{ asset('assets/img/icon_human_black.png') }}">会員一覧</a></li>
	        <li><a href="{{ route('admin.clients.add') }}"><img src="{{ asset('assets/img/icon_people_add_black.png') }}">会員追加</a></li>
	        <li><a href="{{ route('admin.advertisements.index') }}"><img src="{{ asset('assets/img/icon_company_list_black.png') }}">広告出稿一覧</a></li>
	        <li><a href="{{ route('admin.advertisements.add') }}"><img src="{{ asset('assets/img/icon_company_black.png') }}">広告出稿追加</a></li>
	        <li><a href="{{ route('admin.managers.index') }}"><img src="{{ asset('assets/img/icon_human_black.png') }}">管理者一覧</a></li>
	        <li><a href="{{ route('admin.managers.add') }}"><img src="{{ asset('assets/img/icon_people_add_black.png') }}">管理者追加</a></li>
	        <li><a href="{{ route('admin.smss.index') }}"><img src="{{ asset('assets/img/icon_sms_two_black.png') }}">SMS利用状況</a></li>
			<li>
			{{-- <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				ログアウト
			</a> --}}
			<a href="/manage-logout/" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				ログアウト
			</a>
			<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
			</li>
			</ul>
	      </ul>
	    </div>
	  </div>
	</div>
</header><!-- /header -->