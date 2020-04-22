<?php

Route::group(['prefix' => 'vv','namespace' => 'TemPage'], function () {
    // 获取小说的账户配置
    Route::get('gdtpage/{id}', 'GDTController@show')->name('gdt.page.show');

    Route::get('show_b/{id}', 'GDTController@show_b')->name('gdt.load.show_b');

    Route::get('test', 'GDTController@test');


});

