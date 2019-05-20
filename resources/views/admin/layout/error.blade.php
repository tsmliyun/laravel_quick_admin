@if (count($errors) > 0)
    <div class="Huialert Huialert-danger">
        <i class="Hui-iconfont">&#xe6a6;</i>错误状态提示
        <p>  @foreach ($errors->all() as $error){{$error}}!<br/>@endforeach</p>
    </div>
@endif