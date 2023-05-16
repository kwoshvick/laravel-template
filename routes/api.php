<?php

use App\Http\Controllers\SupermarketController;
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

Route::prefix('v1')->group(function () {

    // supermarket
    Route::post('/supermarket/create', [SupermarketController::class, 'create']);

    Route::get('/supermarket/list', [SupermarketController::class, 'list']);
    Route::get('/supermarket/{supermarket}/view', [SupermarketController::class, 'view']);

    Route::put('/supermarket/{supermarket}/update', [SupermarketController::class, 'update']);

    Route::delete('/supermarket/{supermarket}/delete', [SupermarketController::class, 'delete']);

});
