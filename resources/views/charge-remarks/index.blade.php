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
									<h1 class="h1">メモ一覧</h1>
									<span class="en">Charge Remarks List</span>
                                </div>
                                {{--  <div class="content__edit">
									<ul>
                                        <li><a @if ($isCharge) href="{{ route('charge.charges.add') }}" @else href="{{ route('charges.add') }}" @endif>新規追加</a></li>
									</ul>
								</div>  --}}
							</div>
							<div class="content__floar">
								<div class="content__floar__inner">
									<!-- スマホ表示 -->
									<div class="tab">
                                        @if (count($charge_remarks) > 0)
                                        @foreach ($charge_remarks as $remark)
                                        <div class="content__box common__list prime__list">
                                            {{--  <a @if ($isCharge) href="{{ route('charge.charges.show', $charge->id) }}" @else href="{{ route('charges.show', $charge->id) }}" @endif>
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
                                            </a>  --}}
                                            <div class="content__box__inner">
                                                <div class="common__list__head">
                                                    <div class="supplement">
                                                        <span class="sub">内容</span>
                                                    </div>
                                                    <div class="title"><span style="font-weight: 400;">{!! nl2br(e($remark->remarks)) ?? '未記入' !!}</span></div>
                                                </div>
                                                <div class="phone" style="margin-bottom: 5px;"><span>担当者：{{ $remark->charge_name ?? '未定' }}</span></div>
                                                <div class="phone"><span>日　付：{{ date_format($remark->work_on, 'Y-m-d') ?? '未定' }}</span></div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>

									<div class="pc">
                                    <!-- PC表示 -->
                                        @if (count($charge_remarks) > 0)
										<table class="matrer__list">
											<thead>
												<tr>
													<th>担当者名</th>
													<th>日付</th>
													<th>メモ内容</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($charge_remarks as $remark)
												<tr>
                                                    {{--  <td>
                                                        <a @if ($isCharge) href="{{ route('charge.charges.show', $charge->id) }}" @else href="{{ route('charges.show', $charge->id) }}" @endif>
                                                            <span class="title">{{ $charge->name }}</span>
                                                        </a>
													</td>  --}}
                                                    <td style="white-space: nowrap;">{{ $remark->charge_name ?? '未定' }}</td>
                                                    {{--  <td>{{ $remark->work_on ?? '未定' }}</td>  --}}
                                                    <td style="white-space: nowrap;">{{ date_format($remark->work_on, 'Y-m-d') ?? '未定' }}</td>
                                                    <td>{!! nl2br(e($remark->remarks)) ?? '未記入' !!}</td>
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
