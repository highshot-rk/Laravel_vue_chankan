{{ $charge->name }} 様
CATTOBIサービスのログイン情報です。

ログイン情報
ID　[ {{ $charge->email }} ]
パス　[ {{ $password }} ]

ログインURLはこちら
{{ route('charge.login') }}
※ ログインURLをホーム画面にお気に入り登録してください。

@include('emails.info_footer')
