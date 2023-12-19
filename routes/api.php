<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post("/rabbit", function () {
    $publisher = new \App\Services\RabbitService();

    $publisher->publish(json_encode(['user'=> 1, 'value' => 15]));
});

Route::get('checkout/success', \App\Http\Controllers\WalletController::class)->name('success');
