@extends('admin.layout.iframe_main')

@section('content')
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-update">
        {{csrf_field()}}
        <div class="row cl">
            <label for="username" class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
            <div class="formControls col-xs-8 col-sm-4">
                <input type="text" class="input-text radius" value="{{$result['username']}}" placeholder="" id="username" name="username">
            </div>
        </div>
        <div class="row cl">
            <label for="email" class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
            <div class="formControls col-xs-8 col-sm-4">
                <input type="text" class="input-text radius" value="{{$result['email']}}" readonly="readonly" placeholder="@" name="email" id="email">
            </div>
        </div>
        <div class="row cl">
            <label for="phone" class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>联系电话：</label>
            <div class="formControls col-xs-8 col-sm-4">
                <input type="text" class="input-text radius" value="{{$result['phone']}}" placeholder="" id="phone" name="phone">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">角色：</label>
            <div class="formControls col-xs-8 col-sm-4">
                <span class="select-box radius"  style="width:150px;">
                    <select class="select " name="role_id" size="1">
                        <option value="0">请选择</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" @if($result['role_id'] == $role->id) selected @endif>{{$role->name}}</option>
                        @endforeach
                    </select>
			    </span>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{$result['id']}}">
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $("#form-admin-update").validate({
                rules:{
                    username:{
                        required:true
                    },
                    phone:{
                        required:true,
                        isPhone:true
                    },
                    email:{
                        required:true,
                        email:true
                    },
                    role_id:{
                        required:true
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        dataType:'json',
                        url: "{{route('admin.update')}}" ,
                        success: function(data){
                            console.log(data);
                            if (data.status == 'error') {
                                layer.msg(data.error.message, {icon: 2, time: 1500});
                                return false;
                            }
                            layer.msg('编辑成功!',{icon:1,time:1000});
                            window.parent.location.reload();
                            return true;
                        }
                    });
                }
            });
        });
    </script>
@endsection