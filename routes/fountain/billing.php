<?php

Route::group(['prefix' => 'billing', 'as' => 'billing.', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
        Route::get('/', 'InvoicesController@index')->name('index');
        Route::get('{invoice}', 'InvoicesController@download')->name('download');
    });
});