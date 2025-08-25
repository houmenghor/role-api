<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::post('/role',[RoleController::class,'store']);
Route::get('/role',[RoleController::class,'index']);
Route::delete('/role/{id}',[RoleController::class,'destroy']);
Route::put('/role/{id}',[RoleController::class,'update']);

Route::get('/user',[UserController::class,'index']);

Route::prefix('/auth')->group(function () {
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:api');
    Route::post('/forget_password', [AuthController::class, 'forgetPassword']);
});
