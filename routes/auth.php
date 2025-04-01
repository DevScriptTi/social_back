<?php

use App\Http\Controllers\Api\Auth\JoinController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest.sanctum:api')->prefix('auth')->group(function(){
    Route::post('register',[JoinController::class , 'register']);
    Route::post('login',[JoinController::class,'login']);
});

Route::middleware('auth:sanctum')->prefix('auth')->group(function(){
    Route::post('logout',[JoinController::class,'logout']);
});
