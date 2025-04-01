<?php

use App\Http\Controllers\Api\Main\BracletController;
use App\Http\Controllers\Api\Main\ChildrenController;
use App\Http\Controllers\Api\Main\GurdiansController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('/gurdians',GurdiansController::class);
    Route::get('/gurdians/{gurdian}/createKey',[GurdiansController::class, 'createKey']);
    Route::post('/gurdians/{gurdian}/phones',[GurdiansController::class, 'storePhone']);
    Route::match(['patch','put'],'/gurdians/{gurdian}/phones/{phone}',[GurdiansController::class, 'updatePhone']);
    Route::apiResource('/childrens',ChildrenController::class);
    Route::apiResource('/braclets',BracletController::class);

});


require __DIR__.'/auth.php';
