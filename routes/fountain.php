<?php

Route::group(['as' => 'fountain.', 'namespace' => 'Fountain'], function () {
    include 'fountain/admin.php';
    include 'fountain/auth.php';
    include 'fountain/settings.php';
    include 'fountain/billing.php';
    include 'fountain/pages.php';
});
