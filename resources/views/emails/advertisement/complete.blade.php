{{ $advertisement->company }}様

CATTOBIサービスの広告契約締結が完了しました。
本日より掲載開始となります。

掲載URL：
{{ $advertisement->url }}

契約期間：
{{ $contract->started_at->format('Y年m月d日') }}　～　{{ $contract->schedule_ended_at->format('Y年m月d日') }}

@include('emails.info_footer')
