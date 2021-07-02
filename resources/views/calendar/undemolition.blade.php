@include("../components/head")
<body>
    <div id="app">
        @include("../components/nav")
		<div class="wrap flex__wrap f__start">
			@include("../components/sidebar")
			<div class="wrap__right">
				@include("../components/header")
				<div class="allWrapper">
					<div class="content__wrap">
						<div class="content__section">

							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">未解体案件一覧</h1>
									<span class="en">Undisassembled List</span>
								</div>
							</div>
							<div class="content__floar">
								<div class="content__floar__inner">

									<!-- スマホ表示 -->
									<div class="tab">
                                        <yet-project-sp-component is-charge="{{ $isCharge }}" is-viewer="{{ $isViewer }}" url-prefix="{{ $urlPrefix }}"></yet-project-sp-component>
                                    </div>
									<div class="pc">
									<!-- PC表示 -->
	                                @if (count($projects) > 0)
										<table class="matrer__list">
											<thead>
												<tr>
													<th>案件名<br>ステータス</th>
													<th>施工日<br>時間・施工タイプ<br>営業担当</th>
													<th>住所<br>元請け業者<br>元請け電話番号</th>
													<th>備考</th>
												</tr>
											</thead>
											<tbody>
	                                            @foreach ($projects as $project)
	                                            <tr>
                                                    <td>
                                                        <a @if ($isCharge) href="{{ route('charge.yetproject.register', $project->id) }}" @else href="{{ route('yetproject.register', $project->id) }}" @endif>
                                                            <span class="title">{{ $project->name }}</span><br>
                                                            <div class="spent_date" style="display:table-cell; text-align:right;">
                                                                <span class="colorRed bold">経過日数 {{ \Carbon\Carbon::today()->diffInDays( $project->created_at->format('Y/m/d') ) }}日</span>
                                                            </div>
                                                            <ul class="flex__wrap f__start status">
                                                                <li class="@if ($project->is_surveyed) done @endif"><span>現調</span></li>
                                                                <li class="@if ($project->is_notified) done @endif"><span>前日</span></li>
                                                                <li class="@if ($project->is_started)  done @endif"><span>開始</span></li>
                                                                <li class="@if ($project->is_finished) done @endif"><span>終了</span></li>
                                                            </ul>
                                                        </a>
                                                    </td>
                                                    <td><span class="date">{{ $project->workOn() }}</span><br>
                                                        <span class="other">{{ $project->timeTypeName() }}・{{ $project->projectTypeName() }}</span><br>
                                                        <span class="charge">{{ $project->charge->name }}</span></td>
                                                    <td><span class="address">{{ $project->address }}</span><br>
                                                        <span class="company">{{ $project->projectOrderer->company }}</span><br>
                                                        <span class="phone">{{ $project->projectOrderer->tel }}</span></td>
                                                    <td><span class="remark">{{ $project->remark }}</span></td>
	                                            </tr>
	                                            @endforeach
											</tbody>
	                                    </table>
	                                @else
	                                    <span>該当する案件は見つかりませんでした。</span>
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
