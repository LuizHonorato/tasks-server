<?php

use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\TasksController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/categories', CategoriesController::class);
    Route::apiResource('/tasks', TasksController::class);
});
