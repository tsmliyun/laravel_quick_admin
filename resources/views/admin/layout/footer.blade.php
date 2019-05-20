<script type="text/javascript" src="{{asset('H-ui-admin/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('H-ui-admin/lib/layer/2.4/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('H-ui-admin/static/h-ui/js/H-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('H-ui-admin/static/h-ui.admin/js/H-ui.admin.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>