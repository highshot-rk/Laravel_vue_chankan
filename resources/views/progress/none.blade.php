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

@include("../components/head")
<body>
	<div id="app">
		<!-- スマホのみのメニューバー -->
        @auth('web')
		@include("../components/nav")
        @endauth
		<div class="wrap flex__wrap f__start input__area">
            @auth('web')
            @include("../components/sidebar")
            @endauth
            @auth('charge')
            @include("../components/sidebar")
            @endauth
			<div class="wrap__center">
                @auth('web')
                @include("../components/header")
                @endauth
                @auth('charge')
                @include("../components/header")
                @endauth
				<div class="allWrapper">
					<div class="content__wrap">
						<div class="content__section">
							<div class="content__header">
								<div class="content__title">
	                                <h1 class="h1">現場終了済み</h1>
	                                <span class="en">Project Finish</span>
								</div>
							</div>

							<div class="content__floar">
								<div class="content__floar__inner">
									<div class="content__box">
										<div class="content__box__inner">
											<div class="content__text">
	                                            @if ($isFinishedReported)
	                                            <p>
	                                                お疲れ様でした。<br>
	                                                本日の作業はこれにて、終了となります。
	                                            </p>
	                                            @else
												<p>この案件は終了しています。</p>
												<ul>
													<li>{{ $project->name }}</li>
													<li>{{ $project->address }}</li>
	                                            </ul>
	                                            @endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="content__submit f__center">
                            @guest
							<div class="submit__box line">
	                            <a href="http://line.me/R/msg/text/?<?= $lineMessate; ?>" target="_blank" rel="noopener noreferrer">カットビのシステムを<br>友達に紹介する</a>
                            </div>
                            @endguest
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>
