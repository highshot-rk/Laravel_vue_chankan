<?php
$body = <<< EOD
「カットビ」の招待が届いています。##
足場業者が最も評価する共有カレンダーシステム##

▼公式サイトはこちら#
https://zotmansystem.com##

足場のスケジュールをシステムで管理することが可能。#
前日連絡をはじめ、作業開始連絡や完了連絡がボタン一つで完結現場調査報告も写真付きで送れます。##

作業スタッフにも現場の詳細をLINEで送れるので紙に印刷する手間がありません。##

公式サイトの「仮申し込み」ボタンより必要事項を入力して送信して下さい。#
担当者よりご連絡いたします。
EOD;
$lineMessate = str_replace("#", "%0D%0A", $body);
;?>
<nav class="tab commonShadow">
<div class="allWrapper">
    <ul class="flex__wrap">
        <li><a @if ($isCharge) href="{{ route('charge.calendar') }}" @else href="{{ route('calendar') }}" @endif class="f__center">
            <img src="{{ asset('assets/img/icon_calender_black.png') }}"></a></li>
        <li><span id="opneMenu" class="f__center" v-on:click="toggleItem"><img src="{{ asset('assets/img/icon_nav_menu.png') }}"></span></li>
    </ul>
    @if (!$isViewer)

    <div class="plusButton">
        @if (!$isViewer)
        <a @if ($isCharge) href="{{ route('charge.projects.add') }}" @else href="{{ route('projects.add') }}" @endif class="f__center">
        @else
        <a href="" class="f__center">
        @endif
        <img src="{{ asset('assets/img/icon_add_black.png') }}"></a>
    </div>
    @endif
</div>
</nav>
<div class="tab menuTable" :class="{'isOpen': isMenuModal}">
<div class="allWrapper">
<div class="modal__inner">
    <div class="closeMenu" v-on:click="closeItem"><img src="{{ asset('assets/img/icon_batu_black.png') }}"></div>
    <ul>
    <li><a @if ($isCharge) href="{{ route('charge.calendar') }}" @else href="{{ route('calendar') }}" @endif>
        <img src="{{ asset('assets/img/icon_calender_black.png') }}">カレンダー</a></li>
    <li><a @if ($isCharge) href="{{ route('charge.process') }}" @else href="{{ route('process') }}" @endif>
        <img src="{{ asset('assets/img/icon_calender_black.png') }}">工程表</a></li>
    @if (!$isViewer)
    <li><a @if ($isCharge) href="{{ route('charge.orderers.index') }}" @else href="{{ route('orderers.index') }}" @endif>
        <img src="{{ asset('assets/img/icon_human_black.png') }}">元請け一覧</a></li>
    @endif
    <li><a @if ($isCharge) href="{{ route('charge.user.show') }}" @else href="{{ route('user.show') }}" @endif>
        <img src="{{ asset('assets/img/icon_profile_black.png') }}">プロフィール編集</a></li>
    <li><a @if ($isCharge) href="{{ route('charge.term.service') }}" @else href="{{ route('term.service') }}" @endif>
        <img src="{{ asset('assets/img/icon_term_black.png') }}">利用規約</a></li>
    <li><a href="mailto:56@zotman.jp">
        <img src="{{ asset('assets/img/icon_mail_black.png') }}">運営へお問い合わせ</a></li>
    {{-- @if ($loginUser->enable_sms == 1 && !$isViewer)
    <li class="smsCounts">
        <div class="smsCountsBox">
            <span class="haedline">今月SMS料金</span>
            <div class="flex__wrap">
                <span class="payment">¥{{ $priceThisMonth }}</span class="count"> / <span class="count">{{ $countThisMonth }}</span>回
            </div>

        </div>
        <div class="smsCountsBox">
            <span class="haedline">先月SMS料金</span>
            <div class="flex__wrap">
                <span class="payment">¥{{ $pricePrevMonth }}</span> / <span class="count">{{ $countPrevMonth }}回</span>
            </span>
        </div>
    </li>
    @endif --}}
    <li class="lineLink">
        <a href="http://line.me/R/msg/text/?<?= $lineMessate; ?>" target="_blank" rel="noopener noreferrer">カットビのシステムを<br>友達に紹介する</a>
    </li>
    <li>
        @auth('web')
        <a class="textCenter" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form1').submit();">
            ログアウト
        </a>
        @endauth
        @auth('charge')
        <a class="textCenter" href="{{ route('charge.logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form2').submit();">
            ログアウト
        </a>
        @endauth
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    </ul>
</div>
</div>
</div>
