<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

// This group handles all your API routes without adding an extra /api prefix.
Route::group(['middleware' => ['api']], function () {
    Route::post('/role', [RoleController::class, 'store']);
    Route::get('/role', [RoleController::class, 'index']);
    Route::delete('/role/{id}', [RoleController::class, 'destroy']);
    Route::put('/role/{id}', [RoleController::class, 'update']);

    Route::get('/user', [UserController::class, 'index']);

    // Your auth routes will be handled directly here.
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/auth/forget_password', [AuthController::class, 'forgetPassword']);
});
