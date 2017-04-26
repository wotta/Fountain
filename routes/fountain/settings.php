<?php

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
    Route::get('my-account', 'SettingsController@index')->name('index');
    Route::post('update', 'SettingsController@update')->name('update');
    Route::post('change-avatar', 'SettingsController@changeAvatar')->name('changeavatar');
    Route::get('payment-method', 'SettingsController@paymentMethod')->name('paymentmethod');
    Route::post('payment-method-update', 'SettingsController@paymentMethodUpdate')->name('paymentmethodupdate');
    Route::get('default-payment-method/{card}', 'SettingsController@defaultPaymentMethod')->name('defaultpaymentmethod');
});
