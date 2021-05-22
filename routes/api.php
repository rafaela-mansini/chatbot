<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MessagesController;
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
Route::post('messages', [MessagesController::class, 'show']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // $user = auth()->user()->transactions; // to access transactions
    // dd($user);
    return response()->json([ 'testing' => true, "user" => auth()->user() ]);
});
