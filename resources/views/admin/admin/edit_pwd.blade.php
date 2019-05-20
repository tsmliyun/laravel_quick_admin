@extends('admin.layout.main')
@section('content')
    <article class="page-container">
        <form class="form form-horizontal" id="form-update-pwd">
            {{csrf_field()}}
            <div class="row cl">
                <label for="old_pwd" class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原密码：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="password" class="input-text radius" autocomplete="off" value="" placeholder="原密码"
                           id="old_pwd"
                           name="old_pwd">
                </div>
            </div>
            <div class="row cl">
                <label for="new_pwd" class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新密码：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="password" class="input-text radius" autocomplete="off" placeholder="新密码" id="new_pwd"
                           name="new_pwd">
                </div>
            </div>
            <div class="row cl">
                <label for="confirm_new_pwd" class="form-label col-xs-4 col-sm-3"><span
                            class="c-red">*</span>再次输入：</label>
                <div class="formControls col-xs-8 col-sm-4">
                    <input type="password" class="input-text radius" autocomplete="off" placeholder="再次输入"
                           id="confirm_new_pwd"
                           name="confirm_new_pwd">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('script')
    <script type="text/javascript"
            src="{{asset('H-ui-admin/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
    <script type="text/javascript"
            src="{{asset('H-ui-admin/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
    <script type="text/javascript" src="{{asset('H-ui-admin/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $("#form-update-pwd").validate({
                rules: {
                    old_pwd: {
                        required: true
                    },
                    new_pwd: {
                        required: true
                    },
                    confirm_new_pwd: {
                        required: true,
                        equalTo: "#new_pwd"
                    }
                },
                onkeyup: false,
                focusCleanup: true,
                success: "valid",
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: 'post',
                        dataType: 'json',
                        url: "{{route('admin.updatePwd')}}",
                        success: function (data) {
                            console.log(data);
                            if (data.status == 'error') {
                                layer.msg(data.error.message, {icon: 2, time: 1500});
                                return false;
                            }
                            layer.msg('修改成功!', {icon: 1, time: 1000});
                            location.href = "{{route('admin.logout')}}";
                        }
                    });
                }
            });
        });
    </script>
@endsection