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

Route::group(['prefix' => 'account', 'namespace' => 'Account'], function () {
    // 小说平台账户配置列表
    Route::get('/novel_configs', 'NovelController@index')->name('account.novel_list');
    Route::post('/add_novel', 'NovelController@addAccount')->name('account.add_novel');
    // 投放平台账户配置列表
    Route::get('/launch_configs', 'AdvertController@index')->name('account.adv_list');
});

// 数据分析
Route::group(['prefix' => 'data_analyst', 'namespace' => 'Analyze'], function () {
    // 小说数据
    Route::get('/novel_list', 'NovelController@index')->name('analyst.novel_list');

    // 付费趋势
    Route::get('/pay_trend', 'AdvertController@index')->name('analyst.pay_trend');

    Route::get('/detail/pay_trend', 'AdvertController@detailPayTrend')->name('analyst.pay_trend_detail');

    // 成本数据分析
    Route::get('/cost_list', 'AdvertController@showCostList')->name('analyst.cost_list');

});
// 数据管理
Route::group(['prefix' => 'datas_collect', 'namespace' => 'Datas'], function () {
    // 小说数据
    Route::get('/novel_list', 'NovelController@index')->name('datas.novel_list');
    Route::get('/novel_list/orders', 'NovelController@showBookIdOrdersList')->name('datas.bookid.order_list');
    // 手动添加推广成本
    Route::get('/novel_list/orders', 'NovelConnovel_listtroller@showBookIdOrdersList')->name('datas.bookid.order_list');

    // 投放数据分析
    Route::post('/launch/add_money', 'AdvertController@addMoney')->name('datas.adv.add_money');

    // 订单数据明细
    Route::get('/orders_list', 'NovelController@showOrdersList')->name('datas.order_list');


});

// 采集管理
Route::group(['prefix' => 'spy','namespace' => 'SeekData'], function () {
    // 基础配置
    Route::get('config/index', 'Web\ConfigController@index')->name('spy.config.index');
    // 配置清单
    Route::get('config/list', 'Web\ConfigController@showConfigList')->name('spy.config.list');
    // 添加配置
    Route::post('config/add', 'Web\ConfigController@configAdd')->name('spy.config.add');

    // 计划任务
    Route::get('task/scheduler', 'Web\TaskPlanController@index')->name('spy.task.index');
    // 任务列表
    Route::get('task/list', 'Web\TaskPlanController@taskPlanList')->name('spy.task.list');
    // 添加任务
    Route::post('task/add', 'Web\TaskPlanController@taskPlanAdd')->name('spy.task.add');
});
