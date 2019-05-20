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
    <!--[if IE 6]>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/DD_belatedPNG_0.0.8a-min.js')}}"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <title>CRM</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>

<body>
@include('admin.layout.header')
@include('admin.layout.sidebar')

<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <span title="{{$title ?? 'title'}}" data-href="welcome.html">{{$title ?? 'title'}}</span>
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S"
                                                  href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a
                    id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i
                        class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <!-- 填充-->
            @yield("content")
            <!-- end-->
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前</li>
        <li id="closeall">关闭全部</li>
    </ul>
</div>

@include('admin.layout.footer')
@yield('script')
</body>
</html>