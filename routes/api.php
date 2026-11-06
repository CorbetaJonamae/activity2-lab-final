<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AuthController;



// Public
Route::post('/login', [AuthController::class, 'login']);

// Requires a valid token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Admin and regular user: read only
    Route::apiResource('students', StudentController::class)
        ->only(['index', 'show']);

    // Admin only: create, update, delete
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('students', StudentController::class)
            ->only(['store', 'update', 'destroy']);
    });
});