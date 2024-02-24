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
    Route::put('/update-profile', [AuthenticationController::class,'updateProfile']);
    Route::post('/assign-task/{task}', [TaskController::class,'AssignTask'])->middleware('CreatorTasksMiddleware');
    Route::post('/mark-tasks-completed/{task}', [TaskController::class,'MarkTasksAsCompleted'])->middleware('AssignedMiddleware');
    Route::get('/tasks-filter/{filter}', [TaskController::class,'filterTasks']);
    Route::get('/all-tasks-filter/{filter}', [TaskController::class,'filterAllTasks'])->middleware('AdminMiddleware');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/signup', [AuthenticationController::class,'signup']);

