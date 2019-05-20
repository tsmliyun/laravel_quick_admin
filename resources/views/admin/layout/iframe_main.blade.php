<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="/favicon.ico">
    <link rel="Shortcut Icon" href="/favicon.ico"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/html5shiv.js')}}"></script>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{asset('H-ui-admin/static/h-ui/css/H-ui.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('H-ui-admin/static/h-ui.admin/css/H-ui.admin.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('H-ui-admin/lib/Hui-iconfont/1.0.8/iconfont.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('H-ui-admin/static/h-ui.admin/skin/default/skin.css')}}"
          id="skin"/>
    <link rel="stylesheet" type="text/css" href="{{asset('H-ui-admin/static/h-ui.admin/css/style.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{asset('css/page.css')}}"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/DD_belatedPNG_0.0.8a-min.js')}}"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>CRM</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- 填充-->
@include('admin.layout.error')
@include('admin.layout.success')
@yield("content")
<!-- end-->

@include('admin.layout.footer')
@yield('script')
<script>
    $('.refresh-btn').click(function () {
        layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        location.reload();
    });
</script>
</body>
</html>