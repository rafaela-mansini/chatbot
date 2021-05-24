<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\MessagesController;
use App\Http\Controllers\API\TransactionsController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('messages', [MessagesController::class, 'show']);

Route::middleware('auth:api')->group(function() {
    Route::get('transactions/balance', [TransactionsController::class, 'balance']);
    Route::put('transactions/deposit', [TransactionsController::class, 'deposit']);
    Route::put('transactions/withdraw', [TransactionsController::class, 'withdraw']);
    Route::put('config/currency-base', [UsersController::class, 'setCurrencyBase']);
    Route::get('user/list', [UsersController::class, 'show']);
});