<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\Api\CurrencyController;

Route::group([
    'prefix' => 'v1',
    "middleware" => "auth"
], function () {
    Route::group([
        'prefix' => 'currencies',
        'as' => 'currencies.'
    ], function () {
        Route::get("check-code", [CurrencyController::class, "checkCode"])->name('check-code');
        Route::get("update-rates", [CurrencyController::class, "updateRates"])->name('update-rates');

        // TODO: Tirar isto após inserir DataTables
        Route::get('data', [CurrencyController::class, 'dataTable']);
    });
    Route::apiResource('currencies', CurrencyController::class);
});
