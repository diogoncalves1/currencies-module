<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "admin.",
    "prefix" => "admin/",
    "middleware" => "auth"
], function () {
    Route::resource('currencies', \App\Http\Controllers\CurrencyController::class, ['except' => ['store', 'update', 'destroy', /*'show'*/]]);
});

# Api
Route::group([
    'as' => "api.",
    "prefix" => "api/",
    "middleware" => "auth"
], function () {
    Route::resource('currencies', \App\Http\Controllers\Api\CurrencyController::class, ['except' => ['index', 'create', 'edit']]);
    Route::get('currencies/data', [\App\Http\Controllers\Api\CurrencyController::class, 'dataTable']);
});
