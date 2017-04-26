<?php

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
    Route::get('my-account', 'SettingsController@index')->name('index');
    Route::post('update', 'SettingsController@update')->name('update');
    Route::post('change-avatar', 'SettingsController@changeAvatar')->name('changeavatar');
});