<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "admin.",
    "prefix" => "admin/",
    // "middleware" => "auth"
], function () {
    Route::resource('currencies', \App\Http\Controllers\CurrencyController::class, ['except' => ['store', 'update', 'destroy', /*'show'*/]]);
});

# Api
Route::group([
    'as' => "api.",
    "prefix" => "api/",
    // "middleware" => "auth"
], function () {
    Route::group([
        'prefix' => 'currencies/'
    ], function () {
        Route::get("check-code", [\App\Http\Controllers\Api\CurrencyController::class, "checkCode"]);
        Route::get('data', [\App\Http\Controllers\Api\CurrencyController::class, 'dataTable']);
    });
    Route::resource('currencies', \App\Http\Controllers\Api\CurrencyController::class, ['except' => ['index', 'create', 'edit']]);
});
