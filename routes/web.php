<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 欢迎回家
Route::get('/home', 'HomeController@index')->name('home');


//用户管理
Route::group(['prefix' => 'admin_user', 'namespace' => 'AdminUser'], function () {
    Route::get('/list', 'AccountController@list')->name('admin_user.list');
    Route::get('/edit', 'AccountController@edit')->name('admin_user.edit');
    Route::post('/save', 'AccountController@save')->name('admin_user.save');
    Route::delete('/delete_user/{id}', 'AccountController@deleteUser')->name('admin_user.delete_user');
    Route::post('/change_status/{id}', 'AccountController@changeUserStatus')->name('admin_user.change_status');
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    //角色管理
    Route::get('/role_list', 'RoleController@roleList')->name('auth.role_list');
    Route::delete('/delete_role/{id}', 'RoleController@deleteRole')->name('auth.delete_role');
    Route::get('/role_edit', 'RoleController@roleEdit')->name('auth.role_edit');
    Route::post('/role_save', 'RoleController@save')->name('auth.role_save');
    Route::get('/role_permissions/{id}', 'RoleController@rolePermissions')->name('auth.role_permissions');
    Route::put('/save_role_permissions', 'RoleController@saveRolePermissions')->name('auth.save_role_permissions');

    //菜单管理
    Route::get('/permissions_list', 'PermissionController@PermissionList')->name('auth.permissions_list');
    Route::delete('/delete_permissions/{id}', 'PermissionController@deletePermission')->name('auth.delete_permissions');
    Route::get('/permissions_edit', 'PermissionController@permissionEdit')->name('auth.permissions_edit');
    Route::put('/permissions_save', 'PermissionController@save')->name('auth.permissions_save');
    Route::get('/permissions_role', 'PermissionController@permissionsRole')->name('auth.permissions_role');
    Route::put('/permissions_role_save', 'PermissionController@permissionsRoleSave')->name('auth.permissions_role_save');
});

Route::group(['prefix' => 'account', 'namespace' => 'Novel'], function () {
    // 小说平台账户配置列表
    Route::get('/novel_configs', 'NovelAccountController@index')->name('account.novel_list');
    Route::post('/add_novel', 'NovelAccountController@addAccount')->name('account.add_novel');
    // 投放平台账户配置列表
    Route::get('/launch_configs', 'AdvertAccountController@index')->name('account.adv_list');
});
