@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">重置密码</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{route('admin.resetPwd')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <p class="text-muted">请输入新的密码</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_pwd" class="col-md-4 control-label">新密码</label>
                                <div class="col-md-6">
                                    <input id="new_pwd" type="password" class="form-control" name="new_pwd"
                                           value="{{ old('new_pwd') }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_pwd" class="col-md-4 control-label">再次输入</label>
                                <div class="col-md-6">
                                    <input id="confirm_new_pwd" type="password" class="form-control" name="confirm_new_pwd"
                                           value="{{ old('confirm_new_pwd') }}" required autofocus>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="{{$token}}">
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        保存
                                    </button>
                                </div>
                            </div>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4><i class="icon fa fa-ban"></i>错误提示</h4>
                                    <p>  @foreach ($errors->all() as $error){{$error}}!<br/>@endforeach</p>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div id="success-message" class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4><i class="icon fa fa-check"></i> 成功提示!</h4>
                                    {{Session::get('success')}}
                                </div>
                                <script>
                                    setTimeout(
                                        function () {
                                            $(".alert-success").fadeOut();

                                        }, 5000);
                                </script>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
