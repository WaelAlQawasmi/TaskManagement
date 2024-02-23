<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\TaskController;
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

Route::middleware(['middleware1', 'middleware2'])->group(function () {
    Route::resource('task', TaskController::class);
    Route::post('/logout', [AuthenticationController::class,'logout'])->middleware('auth:api');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/signup', [AuthenticationController::class,'signup']);

