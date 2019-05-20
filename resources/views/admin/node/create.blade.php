@extends('admin.layout.iframe_main')

@section('content')

<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="add-node-form">
        {{csrf_field()}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 节点名字：</label>
            <div class="formControls col-xs-8 col-sm-5">
                <input type="text" class="input-text " name="title" required="required" value="{{$result['title'] ?? ''}}">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> 节点路由：</label>
            <div class="formControls col-xs-8 col-sm-5">
                <input type="text" class="input-text" name="path"  value="{{$result['path'] ?? ''}}">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">显示为菜单：</label>
            <div class="formControls col-xs-8 col-sm-5 skin-minimal">
                <div class="radio-box" style="padding-left: 0px;">
                    <input type="radio" id="is_menu_1" name="is_menu" value="1" @if(!empty($result['is_menu']) && $result['is_menu'] == 1) checked @endif>
                    <label for="is_menu_1-1">是</label>
                </div>
                <div class="radio-box" style="padding-left: 0px;">
                    <input type="radio" id="is_menu_2" name="is_menu" value="0" @if(isset($result['is_menu']) && $result['is_menu'] == 0) checked @endif>
                    <label for="is_menu_2">否</label>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">排序：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" name="sort" value="{{$result['sort'] ?? 0}}">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">状态：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box" style="padding-left: 0px;">
                    <input type="radio" id="status-1" name="status" value="1" @if(!empty($result['status']) && $result['status'] == 1) checked @endif>
                    <label for="status-1">启用</label>
                </div>
                <div class="radio-box" style="padding-left: 0px;">
                    <input type="radio" id="status-2" name="status" value="0" @if(isset($result['status ']) && $result['status'] == 0) checked @endif>
                    <label for="status-2">禁用</label>
                </div>
            </div>
        </div>

        <div class="row cl">
            <input type="hidden" value="{{$pid ?? 0}}" name="parent_id"/>
            <input type="hidden" value="{{$level ?? 0}}" name="level"/>
            <input type="hidden" value="{{$result['id'] ?? 0}}" name="id"/>
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-success radius" id="admin-node-save" name="admin-node-save"><i class="icon-ok"></i> 确定</button>
            </div>
        </div>
    </form>
</article>
@endsection
@section('script')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    $(function(){
        //提交
        $('#add-node-form').submit(function(){
            var index;
            $.ajax({
                type:"POST",
                url:"{{$postUrl}}",
                data: $(this).serialize(),
                dataType: 'JSON',
                beforeSend:function(XMLHttpRequest)
                {
                    index = layer.load(0, {shade: false});
                },
                success: function(data){
                    console.log(data);
                    if (data.status == 'error') {
                        layer.msg(data.error.message, {icon: 2, time: 1500});
                        return false;
                    }
                    layer.msg('添加成功!',{icon:1,time:1000});
                    window.parent.location.reload();
                    return true;
                }
            });
            return false;
        })


    });
</script>
@endsection


