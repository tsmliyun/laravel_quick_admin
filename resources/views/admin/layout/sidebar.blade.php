<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="menu-supplier">
            @each('admin.layout.menu',\App\Services\PermissionService::getMenu(),'val')
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a>
</div>