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
							<div class="content__header">
								<div class="content__title">
									<h1 class="h1">検索結果の案件一覧</h1>
									<span class="en">Search Result List</span>
								</div>
							</div>
							<div class="content__floar">
								<div class="content__floar__inner">
	                                <div class="tab">
									<!-- スマホ表示 -->
	                                    @if (count($projects) > 0)
	                                    @foreach ($projects as $project)
										<div class="content__box common__list">
											<div class="content__box__inner">
												<div class="common__list__head">
													<div class="supplement">
	                                                    <span class="sub">{{ $project->timeTypeName() }}・{{ $project->projectTypeName() }}</span>
	                                                    /
	                                                    <span class="charge">{{ $project->charge->name }}</span>
													</div>
	                                                <div class="title">
	                                                    <a @if ($isCharge) href="{{ route('charge.projects.show', $project->id) }}" @else href="{{ route('projects.show', $project->id) }}" @endif>
	                                                    <span>{{ $project->name }}</span></a>
	                                                </div>
													<ul class="flex__wrap f__start status">
	                                                    <li class="@if ($project->is_surveyed) done @endif"><span>現調</span></li>
	                                                    <li class="@if ($project->is_notified) done @endif"><span>前日</span></li>
	                                                    <li class="@if ($project->is_started)  done @endif"><span>開始</span></li>
	                                                    <li class="@if ($project->is_finished) done @endif"><span>終了</span></li>
														<li><a href="https://www.google.com/maps/search/?api=1&query={{ $project->address }}" target="_blank" rel="nofollor">MAP</a></li>
                                                    </ul>
												</div>
												<div class="common__list__body">
													<ul class="others">
														<li class="address bgCenterCover">{{ $project->address }}</li>
														<li class="company bgCenterCover">{{ $project->projectOrderer->company }}</li>
														<li class="phone bgCenterCover">{{ $project->projectOrderer->tel }}</li>
													</ul>
												</div>
											</div>
	                                    </div>
	                                    @endforeach
	                                    @else
	                                        <span>該当する案件は見つかりませんでした。</span>
	                                    @endif
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
													{{-- <a href="{{ route('projects.show', $project->id) }}"> --}}
														<td>
	                                                        <a @if ($isCharge) href="{{ route('charge.projects.show', $project->id) }}" @else href="{{ route('projects.show', $project->id) }}" @endif>
	                                                            <span class="title">{{ $project->name }}</span><br>
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
													{{-- </a> --}}
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
