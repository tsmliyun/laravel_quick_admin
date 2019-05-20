@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">找回密码</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{route('admin.retrievePassSendMail')}}">
                            {{ csrf_field() }}

                            <div class="form-group{{!empty($errors) && $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>
                                    @if (!empty($errors) && $errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        找回密码
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <p class="text-muted">修改密码链接已发送至邮箱，请在邮箱中点击修改密码。</p>
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
