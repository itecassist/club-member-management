<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\Auth\AuthController::class, 'refresh']);
    Route::get('me', [\App\Http\Controllers\Auth\AuthController::class, 'me']);
    Route::get('user', fn(Request $request) => $request->user());

    if (file_exists(__DIR__ . '/Auth.php')) {
        require __DIR__ . '/Auth.php';
    }
    
    if (file_exists(__DIR__ . '/Members.php')) {
        require __DIR__ . '/Members.php';
    }
    if (file_exists(__DIR__ . '/Tenancy.php')) {
        require __DIR__ . '/Tenancy.php';
    }
});

