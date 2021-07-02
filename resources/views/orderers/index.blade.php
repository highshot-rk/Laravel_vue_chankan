@include("../components/head")
<body>
	<div id="app">
		<!-- スマホのみのメニューバー -->
		@include("../components/nav")
		<div class="wrap flex__wrap f__start">
			@include("../components/sidebar")
			<div class="wrap__right">
				@include("../components/header")
				<div class="allWrapper">
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

	                        {{-- 更新後のメッセージ表示 --}}
	                        @if (session('message'))
	                        <p>{{ session('message') }}</p>
	                        @endif

	                        <div class="content__header">
								<div class="content__title">
									<h1 class="h1">元請け業者一覧</h1>
									<span class="en">Prime Contractor List</span>
	                            </div>

	                            <div class="content__edit">
									<ul>
                                        <li><a @if ($isCharge) href="{{ route('charge.orderers.add') }}" @else href="{{ route('orderers.add') }}" @endif>
                                        新規追加</a></li>
									</ul>
								</div>
							</div>
							<div class="content__floar">
								<div class="content__floar__inner">

									<!-- スマホ表示 -->
									<div class="tab">
	                                    @if (count($projectOrderers) > 0)

	                                    @foreach ($projectOrderers as $projectOrderer)
	                                    <div class="content__box common__list prime__list">
                                            <a @if ($isCharge) href="{{ route('charge.orderers.show', $projectOrderer->id) }}" @else href="{{ route('orderers.show', $projectOrderer->id) }}" @endif>
												<div class="content__box__inner">
													<div class="common__list__head">
														<div class="supplement">
															<span class="sub">会社名</span>
														</div>
														<div class="title"><span>{{ $projectOrderer->company }}</span></div>
													</div>

	                                                <div class="phone"><img src="{{ asset('assets/img/icon-sp-black.png') }}" alt="">
	                                                    {{ $projectOrderer->phone }}
	                                                </div>
												</div>
	                                        </a>
	                                    </div>
	                                    @endforeach
	                                    @endif
	                                </div>

									<div class="pc">
	                                <!-- PC表示 -->
	                                    @if (count($projectOrderers) > 0)
										<table class="matrer__list">
											<thead>
												<tr>
													<th>会社名<br>会社名（カナ）</th>
													<th>携帯番号</th>
													<th>郵便番号<br>住所</th>
													<th>代表者名<br>代表者名（カナ）</th>
													<th>電話番号<br>ファックス</th>
													<th>備考</th>
												</tr>
											</thead>
											<tbody>
	                                            @foreach ($projectOrderers as $projectOrderer)
												<tr>
	                                                <td>
                                                        <a @if ($isCharge) href="{{ route('charge.orderers.show', $projectOrderer->id) }}" @else href="{{ route('orderers.show', $projectOrderer->id) }}" @endif>
	                                                        <span class="title">{{ $projectOrderer->company }}</span><br>
	                                                        <span class="kana">{{ $projectOrderer->company_kana }}</span>
	                                                    </a>
													</td>
													<td><span class="phone">{{ $projectOrderer->phone }}</span></td>
	                                                <td><span class="zip">〒{{ $projectOrderer->zip }}</span><br>
	                                                    <span class="address">{{ $projectOrderer->address }}</span></td>
	                                                <td><span class="president">{{ $projectOrderer->president }}</span><br>
	                                                    <span class="prekana">{{ $projectOrderer->president_kana }}</span></td>
	                                                <td><span class="tel">{{ $projectOrderer->tel }}</span><br>
	                                                    <span class="fax">{{ $projectOrderer->fax }}</span></td>
													<td><span class="remark">{{ $projectOrderer->remark }}</span></td>
	                                            </tr>
	                                            @endforeach
											</tbody>
	                                    </table>
	                                    @endif
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
