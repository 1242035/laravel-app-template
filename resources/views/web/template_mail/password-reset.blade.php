<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
<div style="white-space: pre;">
    {{$name ?? ''}}　様

この度は「ABC」をご利用いただき、誠にありがとうございます。
パスワードの再発行のご依頼を受け付けました。
下記URLをクリックして、パスワードの再設定画面から 新しいパスワードを設定してください。 
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
URL：<a href="{!! route('web.reset-password-view', ['token' => $token ?? '']) !!}" target="_blank">{!! route('web.reset-password-view', ['token' => $token ?? '']) !!}</a>
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
登録した覚えがないのにこのメールを受け取られた方は、お手数ですがこのメールを削除してください。 
※このメールは送信専用メールアドレスから配信されています。
このままご返信いただいてもお答えできませんのでご了承ください。
  
</div>
</body>
</html>
