<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsoleController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/consoles', [ConsoleController::class, 'index']);
Route::get('/consoles/{id}', [ConsoleController::class, 'show']);
Route::post('/consoles', [ConsoleController::class, 'store']);
Route::put('/consoles/{id}', [ConsoleController::class, 'update']);
Route::delete('/consoles/{id}', [ConsoleController::class, 'destroy']);