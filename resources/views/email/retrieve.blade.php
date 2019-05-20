<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>找回密码</title>
</head>
<body>
亲爱的用户 {{$username}}：您好！
<p>您收到这封这封电子邮件是因为您 (也可能是某人冒充您的名义) 申请了一个新的密码。假如这不是您本人所申请, 请不用理会这封电子邮件, 但是如果您持续收到这类的信件骚扰, 请您尽快联络管理员。</p>
<p>要使用新的密码, 请使用以下链接启用密码。</p>
<p>{{$link}}</p>
<p>(如果无法点击该URL链接地址，请将它复制并粘帖到浏览器的地址输入框，然后单击回车即可。该链接使用后将立即失效。)</p>
<p>注意:请您在收到邮件{{$minutes}}分钟内({{$endTime}}前)使用，否则该链接将会失效。</p>
<p>如有问题请联系管理员：{{$admin}}</p>
</body>
</html>