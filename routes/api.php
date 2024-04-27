<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\TaskController;
use App\Http\Controllers\API\v1\CategoryController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'userRegister']);
Route::middleware('jwt.verify')->group(function () {
    Route::post('user-profile', [AuthController::class, 'userProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);

    Route::post('task-status/{task}/status', [TaskController::class, 'updateTaskStatus'])->middleware('throttle:1,1'); ;
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('categories', CategoryController::class);
});

