<?php

Route::group(['prefix' => 'settings', 'namespace' => 'user', 'as' => 'settings.', 'middleware' => ['auth']], function() {
    Route::get('my-account', 'SettingsController@index')->name('index');
    Route::post('update', 'SettingsController@update')->name('update');
    Route::post('change-avatar', 'SettingsController@changeAvatar')->name('changeavatar');

    Route::get('password', 'SecurityController@password')->name('password');
    Route::post('changepassword', 'SecurityController@changePassword')->name('changepassword');
});
