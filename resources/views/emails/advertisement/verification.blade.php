{{ $advertisement->company }}様

CATTOBIサービスの広告契約締結のご案内です。

下記URLにアクセスし、利用規約にをご確認頂き
ご同意頂きましたら掲載開始となります。

{{ route('contracts.confirm', $token) }}

@include('emails.info_footer')
