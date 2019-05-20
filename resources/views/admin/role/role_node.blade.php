@extends('admin.layout.iframe_main')

@section('content')
<style>
    .level-3 input[type=checkbox] {
        margin-left:15px;
    }
</style>

<div class="page-container">
    <p>&nbsp;
        <a class="btn btn-primary radius" href="javascript:;" id="save-btn">保存</a>
    </p>
    <table class="table table-border table-bordered table-striped table-hover">
        <tr>
            <th>节点</th>
        </tr>
        <tr>
            <td>
                <input type="checkbox" id="all-check">
                全选
            </td>
        </tr>
        @foreach($nodeTree as $key => $value)
            <tr class="level-1">
                <td>
                    <input type="checkbox" value="{{$value['id']}}" class="node-check">
                {{$value['title']}}<!-- （目录） -->
                </td>
            </tr>

            @if(!empty($value['child']))
                @foreach ($value['child'] as $k => $v)

                    <tr class="level-2">
                        <td style="padding-left: 40px;">
                            <input type="checkbox" value="{{$v['id']}}" class="node-check">
                        {{$v['title']}}<!-- （<notempty name="v.is_menu">页面<else/>请求</notempty>） -->
                        </td>
                    </tr>


                    @if(!empty($v['child']))
                        <tr class="level-3">
                            <td style="padding-left: 80px;">
                                @foreach ($v['child'] as $k1 => $v1)
                                    <input type="checkbox" value="{{$v1['id']}}"
                                           class="node-check">{{$v1['title']}}<!-- （<notempty name="v1.is_menu">页面<else/>请求</notempty>） -->
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach
</table>

<p></p>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(function(){

        // 选中状态
        var checked_node = [{{implode(',',$roleNode)}}];
        $.each(checked_node, function(key, value){
            $('.node-check[value="' + value + '"]').prop('checked', true)
        })

        // 全选
        $('#all-check').click(function(){
            var _checked = $(this).prop('checked');
            if(_checked == true)
            {
                $('.node-check').prop('checked', true);
            }
            else if(_checked == false)
            {
                $('.node-check').prop('checked', false);
            }
        })

        // 选择向下/向上覆盖
        $('.node-check').click(function(){
            var _checked = $(this).prop('checked');
            var _tr = $(this).closest('tr');

            if(_tr.attr('class') == 'level-2'){
                _tr.prev('.level-1').find('.node-check').prop('checked', _checked);
            }

            if(_tr.attr('class') == 'level-3'){
                _tr.prev('.level-2').find('.node-check').prop('checked', _checked);
            }

            if(_tr.attr('class') == 'level-2' && _tr.next('tr').attr('class') == 'level-3')
            {
                _tr.nextUntil('.level-2').find('.node-check').prop('checked', _checked);

            }
            else if(_tr.attr('class') == 'level-1')
            {
                _tr.nextUntil('.level-1').find('.node-check').prop('checked', _checked)
            }

        })

        // 保存
        $('#save-btn').click(function(){
            var _node_data = [];
            $('.node-check:checked').each(function(){
                _node_data.push($(this).val())
            })
            $.ajax({
                type:"POST",
                url:"{{route('role.updatePermission')}}",
                data: {
                    'permission_id' : _node_data,
                    'role_id' : "{{$roleId}}"
                },
                dataType: 'JSON',
                beforeSend:function(XMLHttpRequest)
                {
                    index = layer.load(0, {shade: false});
                },
                success:function(data)
                {
                    console.log(data);
                    if (data.status == 'error') {
                        layer.msg(data.error.message, {icon: 2, time: 1500});
                        return false;
                    }
                    layer.msg('修改成功!',{icon:1,time:1000});
                    window.parent.location.reload();
                    return true;
                }
            });
            return true;
        })
    })
</script>
@endsection