<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;

// Registration Route
Route::post('register', [AuthController::class, 'register']);

// Login Route
Route::post('login', [AuthController::class, 'login']);

//protect routes with Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    //user task routs
    Route::post('/tasks', [TaskController::class, 'create']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/done', [TaskController::class, 'done']);
    Route::get('/tasks/not-done', [TaskController::class, 'notDone']);
    Route::get('/tasks/in-progress', [TaskController::class, 'inProgress']);
});
