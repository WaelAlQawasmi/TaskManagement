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

Route::middleware(['auth:api'])->group(function () {
    Route::resource('task', TaskController::class);
    Route::post('/logout', [AuthenticationController::class,'logout']);
    Route::post('/assign-task', [AuthenticationController::class,'AssignTask'])->middleware('CreatorTasksMiddleware');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/signup', [AuthenticationController::class,'signup']);

