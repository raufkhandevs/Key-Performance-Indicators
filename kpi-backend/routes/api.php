<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\KPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'info']);

Route::controller(KPIController::class)->prefix('/kpi')->group(function () {
    Route::post('/legacy', 'storeLegacy');
    Route::post('/', 'store');
    Route::get('/status', 'status');
});
