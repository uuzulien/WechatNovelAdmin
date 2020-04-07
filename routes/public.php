<?php
/**
 * Created by PhpStorm.
 * User: 36390
 * Date: 2020/3/22
 * Time: 1:21
 */

//首页
Route::get('/login', 'AdminUser\AccountController@login')->name('login');
Route::post('/doLogin', 'AdminUser\AccountController@doLogin')->name('doLogin');

//退出登录
Route::get('/logout', 'AdminUser\AccountController@logout');

//个人资料修改
Route::group([ 'namespace' => 'AdminUser','middleware'=>'authWeb'], function () {
    Route::get('/edit_user', 'AccountController@editUser')->name('editUser');
    Route::post('/save_user', 'AccountController@saveUser')->name('saveUser');
});
