<?php

/**
 * 后台模块
 */

Route::get('/', function () {
    return redirect()->to('admin/logout');
});

// 登陆模块
Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login')->name('admin.login');
Route::get('logout', 'LoginController@logout')->name('admin.logout');
Route::get('retrievePwd', 'LoginController@retrievePwd')->name('admin.retrievePwd');
Route::post('retrievePassSendMail', 'LoginController@retrievePassSendMail')->name('admin.retrievePassSendMail');
Route::get('resetPwdView', 'LoginController@resetPwdView')->name('admin.resetPwdView');
Route::post('resetPwd', 'LoginController@resetPwd')->name('admin.resetPwd');

Route::group(['middleware' => ['admin.authenticate','check.access']], function () {

    // 首页
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::get('editPwd', 'AdminController@editPwd')->name('admin.editPwd');
    Route::post('updatePwd', 'AdminController@updatePwd')->name('admin.updatePwd');

    // 管理员管理
    Route::group(['prefix' => 'admin'], function () {
        Route::get('lists', 'AdminController@index')->name('admin.lists');
        Route::get('create', 'AdminController@create')->name('admin.create');
        Route::post('store', 'AdminController@store')->name('admin.store');
        Route::get('edit', 'AdminController@edit')->name('admin.edit');
        Route::post('update', 'AdminController@update')->name('admin.update');
        Route::post('destroy', 'AdminController@destroy')->name('admin.destroy');
    });

    // 权限节点管理
    Route::group(['prefix' => 'permission'], function () {
        Route::get('lists', 'PermissionController@index')->name('permission.lists');
        Route::get('create', 'PermissionController@create')->name('permission.create');
        Route::post('store', 'PermissionController@store')->name('permission.store');
        Route::get('edit', 'PermissionController@edit')->name('permission.edit');
        Route::post('update', 'PermissionController@update')->name('permission.update');
        Route::post('destroy', 'PermissionController@destroy')->name('permission.destroy');
        Route::post('updateField', 'PermissionController@updateField')->name('permission.updateField');
    });

    // 角色管理
    Route::group(['prefix' => 'role'], function () {
        Route::get('lists', 'RoleController@index')->name('role.lists');
        Route::get('create', 'RoleController@create')->name('role.create');
        Route::post('store', 'RoleController@store')->name('role.store');
        Route::get('edit', 'RoleController@edit')->name('role.edit');
        Route::post('update', 'RoleController@update')->name('role.update');
        Route::post('destroy', 'RoleController@destroy')->name('role.destroy');
        Route::post('updateField', 'RoleController@updateField')->name('role.updateField');
        Route::get('permission', 'RoleController@permission')->name('role.permission');
        Route::post('updatePermission', 'RoleController@updatePermission')->name('role.updatePermission');
    });

    // 会员分组
    Route::group(['prefix' => 'customer/group'], function () {
        Route::get('lists', 'CustomerGroupController@index')->name('customer.group.lists');
        Route::get('edit', 'CustomerGroupController@edit')->name('customer.group.edit');
    });
});



