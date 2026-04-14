<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyJobController;
use App\Http\Controllers\Api\FreelancerJobController;

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // Company endpoints (assuming role handling is purely logic-based or implicitly handled)
    Route::prefix('company')->group(function () {
        Route::get('/jobs', [CompanyJobController::class, 'index']);
        Route::post('/jobs', [CompanyJobController::class, 'store']);
        Route::put('/jobs/{job}', [CompanyJobController::class, 'update']);
        Route::get('/jobs/{job}/applications', [CompanyJobController::class, 'applications']);
    });

    // Freelancer endpoints
    Route::prefix('freelancer')->group(function () {
        Route::get('/jobs', [FreelancerJobController::class, 'index']);
        Route::post('/jobs/{job}/apply', [FreelancerJobController::class, 'apply']);
    });
});
