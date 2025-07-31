<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "admin.",
    "prefix" => "admin/",
    "middleware" => "auth"
], function () {
    Route::resource('currency', \App\Http\Controllers\CurrencyController::class);
});

# Api
Route::group([
    'as' => "api.",
    "prefix" => "api/",
    "middleware" => "auth"
], function () {
    Route::get('currency/data', [\App\Http\Controllers\Api\CurrencyController::class, 'dataTable']);
});