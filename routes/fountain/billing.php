<?php

Route::group(['prefix' => 'billing', 'namespace' => 'billing', 'as' => 'billing.', 'middleware' => ['auth']], function () {
    Route::get('subscription', 'SubscriptionController@index')->name('subscriptionindex');
    Route::get('payment-method', 'PaymentController@paymentMethod')->name('paymentmethod');
    Route::post('payment-method-update', 'PaymentController@paymentMethodUpdate')->name('paymentmethodupdate');
    Route::get('default-payment-method/{card}', 'PaymentController@defaultPaymentMethod')->name('defaultpaymentmethod');
    Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
        Route::get('/', 'InvoicesController@index')->name('index');
        Route::get('{invoice}', 'InvoicesController@download')->name('download');
    });
});
