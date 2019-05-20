@if(Session::has('success'))
    <div class="Huialert Huialert-success alert-msg">
        <i class="Hui-iconfont">&#xe6a6;</i>成功状态提示
        {{Session::get('success')}}
    </div>
    <script>
        setTimeout(
            function () {
                $(".alert-msg").fadeOut();

            }, 3000);
    </script>
@endif

