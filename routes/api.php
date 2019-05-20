<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 设置语言
App::setLocale(\Request::header('lang', 'zh'));

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
//    $api->get('test',function (){
//        echo 111;exit;
//    });
    $api->get('test', 'App\Http\Controllers\Api\V1\TestController@index');
});


$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    // 登陆模块
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('auth', 'AuthController@auth'); // 登陆
        $api->post('logout', 'AuthController@logout'); // 注销
//        $api->post('refresh', 'AuthController@refresh'); // 刷新token
        $api->get('me', 'AuthController@me')->middleware('refresh.token'); // 获取当前用户信息
    });
//    refresh.token', 'check.access
    $api->group(['middleware' => []], function ($api) {
        // 用户管理
        $api->group(['prefix' => 'admin'], function ($api) {
            $api->get('lists', 'AdminController@index'); // 管理员列表
            $api->post('create', 'AdminController@store'); // 新增管理员
            $api->get('edit', 'AdminController@edit'); // 编辑管理员
            $api->post('edit', 'AdminController@update'); // 编辑管理员
            $api->post('destroy', 'AdminController@destroy'); // 删除管理员
            $api->post('resetPwd', 'AdminController@resetPwd'); // 重置密码
            $api->post('updatePwd', 'AdminController@updatePwd'); // 修改密码
            $api->post('retrievePwd', 'AdminController@retrievePass'); // 找回密码
        });

        // 角色管理
        $api->group(['prefix' => 'role'], function ($api) {
            $api->get('lists', 'RoleController@index'); // 角色列表
            $api->post('create', 'RoleController@store'); // 新增角色
            $api->get('view', 'RoleController@view'); // 查看角色
            $api->put('edit', 'RoleController@edit'); // 编辑角色
            $api->delete('destroy', 'RoleController@destroy'); // 删除角色
            $api->post('updatePermission', 'RoleController@updatePermission'); // 修改角色拥有的权限
            $api->get('permission', 'RoleController@permission'); // 修改角色拥有的权限
        });

        // 权限管理
        $api->group(['prefix' => 'permission'], function ($api) {
            $api->get('lists', 'PermissionController@index');
            $api->post('create', 'PermissionController@store');
            $api->get('view', 'PermissionController@view');
            $api->put('edit', 'PermissionController@edit');
            $api->delete('destroy', 'PermissionController@destroy');
            $api->get('menu', 'PermissionController@menu');
            $api->get('tree', 'PermissionController@permissionTree');
        });

        # 优惠券
        $api->group(['prefix' => 'coupon'], function ($api) {
            $api->get('lists', 'CouponController@lists');
            $api->get('view', 'CouponController@view');
            $api->post('create', 'CouponController@create');
            $api->put('edit', 'CouponController@edit');
            $api->get('customers', 'CouponController@customers');
        });

        // 会员配置
        $api->group(['prefix' => 'config'], function ($api) {
            $api->get('lists', 'CustomerConfigController@index');
            $api->post('create', 'CustomerConfigController@store');
            $api->put('edit', 'CustomerConfigController@edit');
        });

        // 系统配置字段
        $api->get('params', 'ParamController@index');

        // 会员分组
        $api->group(['prefix' => 'customer/group'], function ($api) {
            $api->get('lists', 'CustomerGroupController@index');
            $api->get('view', 'CustomerGroupController@view');
            $api->post('create', 'CustomerGroupController@store');
            $api->put('edit', 'CustomerGroupController@edit');
            $api->delete('destroy', 'CustomerGroupController@destroy');
        });

        // 会员
        $api->group(['prefix' => 'customer'], function ($api) {
            $api->get('lists', 'CustomerController@index');
            $api->get('view', 'CustomerController@view');
            $api->post('sendCoupon', 'CustomerController@sendCoupon');
            $api->post('sendWechat', 'CustomerController@sendWechat');
            $api->post('sendMsg', 'CustomerController@sendMsg');
            $api->get('attribute', 'CustomerController@attribute');
            $api->get('lable', 'CustomerController@lable');
            $api->get('orders', 'CustomerController@orders');
            $api->get('levelLog', 'CustomerController@levelLog');
            $api->get('pointLog', 'CustomerController@pointLog');
            $api->get('cards', 'CustomerController@cards');
            $api->get('cardLog', 'CustomerController@cardLog');
        });

        // 订单
        $api->group(['prefix' => 'order'], function ($api) {
            $api->get('lists', 'OrderController@index');
        });

    });
});
