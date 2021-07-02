

{{-- viewファイル --}}
@include("../components/head")
@extends('layouts.manage')
@section('title', 'SMS利用履歴')
@section('content')
	<div class="content__wrap">
		<div class="content__section">
			<div class="content__header">
				<div class="content__title">
					<h1 class="h1">SMS利用履歴</h1>
					<span class="en">SMS History</span>
				</div>
			</div>
			<div class="content__floar">
				<div class="content__floar__inner">

					<!-- スマホ表示 -->
					<div class="tab">
						<div class="content__box common__list prime__list">
							{{-- <a href=""> --}}
	                            @foreach ($users as $user)
								<div class="content__box__inner">
									<div class="common__list__head">
										<div class="supplement">
											<span class="sub">会社名</span>
										</div>
										<div class="title"><span>{{ $user->company }}</span></div>
									</div>

									<div class="url">{{ calcMonth($month, 0) }}月：¥{{ $user->smssPrice($year, $month, 0) }} / {{ $user->smssCount($year, $month, 0) }}回</div>
									<div class="url">{{ calcMonth($month, -1) }}月：¥{{ $user->smssPrice($year, $month, -1) }} / {{ $user->smssCount($year, $month, -1) }}回</div>
									<div class="url">{{ calcMonth($month, -2) }}月：¥{{ $user->smssPrice($year, $month, -2) }} / {{ $user->smssCount($year, $month, -2) }}回</div>
									<div class="url">{{ calcMonth($month, -3) }}月：¥{{ $user->smssPrice($year, $month, -3) }} / {{ $user->smssCount($year, $month, -3) }}回</div>
	                            </div>
	                            @endforeach
							{{-- </a> --}}
	                	</div>
	                </div>
					<div class="pc">

						<!-- PC表示 -->
						<table class="matrer__list">
							<thead>
								<tr>
									<th>会社名<br></th>
									<th>メールアドレス<br>電話番号</th>
									<th colspan="4">SMS利用履歴</th>
								</tr>
								<tr>
									<th colspan="2"></th>
									<th>{{ calcMonth($month, 0) }}月</th>
									<th>{{ calcMonth($month, -1) }}月</th>
									<th>{{ calcMonth($month, -2) }}月</th>
									<th>{{ calcMonth($month, -3) }}月</th>
								</tr>
							</thead>
							<tbody>
	                            @foreach ($users as $user)
								 <tr>
									<td><span class="title">{{ $user->company }}</span><br><span class="kana">{{ $user->company_kana }}</span>
									</td>
									<td><span class="mail">{{ $user->email }}</span><br><span class="phone">{{ $user->phone }}</span></td>
									<td>¥{{ $user->smssPrice($year, $month, 0) }} / {{ $user->smssCount($year, $month, 0) }}回</td>
									<td>¥{{ $user->smssPrice($year, $month, -1) }} / {{ $user->smssCount($year, $month, -1) }}回</td>
									<td>¥{{ $user->smssPrice($year, $month, -2) }} / {{ $user->smssCount($year, $month, -2) }}回</td>
									<td>¥{{ $user->smssPrice($year, $month, -3) }} / {{ $user->smssCount($year, $month, -3) }}回</td>
	                            </tr>
	                            @endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
