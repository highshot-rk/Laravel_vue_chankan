{{ $user->name }} 様
CATTOBIサービスのログイン情報です。

ログイン情報
ID　[ {{ $user->email }} ]
パス　[ {{ $password }} ]

ログインURLはこちら
{{ route('login') }}
※ ログインURLをホーム画面にお気に入り登録してください。

@include('emails.info_footer')
