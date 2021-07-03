{{-- viewファイル --}}
@extends('layouts.user')

@section('title', 'カレンダー')
@section('content')
    <div class="allWrapper calender">
        <div class="content__wrap">
            <div class="content__section">
                <div class="content__floar">
                    <div class="content__floar__inner">
                        <!-- スマホ表示 -->
                        <div class="calender__table">
                            {!!$cal_tag!!}
                        </div>
                        @if(!$isViewer)
                            <div class="content__submit f__center">
                                <div class="submit__box">
                                    <a @if ($isCharge) href="{{ route('charge.yetproject.index') }}" @else href="{{ route('yetproject.index') }}" @endif>未解体案件一覧</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
