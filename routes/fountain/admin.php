<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::post('/', 'UsersController@store')->name('store');
        Route::get('create', 'UsersController@create')->name('create');
        Route::get('{user}', 'UsersController@show')->name('show');
        Route::get('{user}/edit', 'UsersController@edit')->name('edit');
        Route::patch('{user}', 'UsersController@update')->name('update');
        Route::delete('{user}', 'UsersController@destroy')->name('destroy');
        Route::delete('{user}/unbsubscribe/{plan}', 'UsersController@unsubscribe')->name('unsubscribe');
        Route::get('login-as/{id}', 'UsersController@login')->name('login-as');
    });

    Route::group(['prefix' => 'plans', 'as' => 'plans.'], function () {
        Route::get('/', 'PlansController@index')->name('index');
        Route::post('/', 'PlansController@store')->name('store');
        Route::get('create', 'PlansController@create')->name('create');
        Route::get('{plan}', 'PlansController@show')->name('show');
        Route::delete('{plan}', 'PlansController@destroy')->name('destroy');
    });
});
