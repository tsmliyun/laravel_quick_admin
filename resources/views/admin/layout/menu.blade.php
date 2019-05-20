<dt>{{$val['title']}}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
<dd>
    <ul>
        @foreach($val['child'] as $v)
            <li><a data-href="{{url($v['path'])}}" title="{{$v['title']}}" data-title="{{$v['title']}}"
                   href="javascript:void(0)">{{$v['title']}}</a></li>
        @endforeach
    </ul>
</dd>
