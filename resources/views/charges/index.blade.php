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
									<h1 class="h1">スタッフ一覧</h1>
									<span class="en">Charges List</span>
                                </div>
                                <div class="content__edit">
									<ul>
                                        <li><a @if ($isCharge) href="{{ route('charge.charges.add') }}" @else href="{{ route('charges.add') }}" @endif>新規追加</a></li>
									</ul>
								</div>
							</div>
							<div class="content__floar">
								<div class="content__floar__inner">
									<!-- スマホ表示 -->
									<div class="tab">
                                        @if (count($charges) > 0)
                                        @foreach ($charges as $charge)
                                        <div class="content__box common__list prime__list">
                                            <a @if ($isCharge) href="{{ route('charge.charges.show', $charge->id) }}" @else href="{{ route('charges.show', $charge->id) }}" @endif>
												<div class="content__box__inner">
													<div class="common__list__head">
														<div class="supplement">
															<span class="sub">名前</span>
														</div>
														<div class="title"><span>{{ $charge->name }}</span></div>
													</div>
                                                    <div class="phone"><img src="{{ asset('assets/img/icon-sp-black.png') }}" alt="">
                                                        {{ $charge->phone }}
                                                    </div>
												</div>
                                            </a>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>

									<div class="pc">
                                    <!-- PC表示 -->
                                        @if (count($charges) > 0)
										<table class="matrer__list">
											<thead>
												<tr>
													<th>担当者名</th>
													<th>電話番号</th>
													<th>タイプ</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($charges as $charge)
												<tr>
                                                    <td>
                                                        <a @if ($isCharge) href="{{ route('charge.charges.show', $charge->id) }}" @else href="{{ route('charges.show', $charge->id) }}" @endif>
                                                            <span class="title">{{ $charge->name }}</span>
                                                        </a>
													</td>
                                                    <td><span class="fax">{{ $charge->phone }}</span></td>
													<td>
                                                        <span class="type">
                                                            @if($charge->edit_type == 0)編集者
                                                            @elseif($charge->edit_type == 1)閲覧者
                                                            @endif
                                                        </span>
                                                    </td>
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
