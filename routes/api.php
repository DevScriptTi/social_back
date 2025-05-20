<?php

use App\Http\Controllers\Api\Main\ApplicationsController;
use App\Http\Controllers\Api\Users\AdminsController;
use App\Http\Controllers\Api\Users\CommitteeController;
use App\Http\Controllers\Api\Users\EmployeesController;
use App\Models\Api\Core\Wilaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json(["user" => $request->user()->load('key.keyable.photo')], 200);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('admins', AdminsController::class);
    Route::post('admins/{admin}/generate-key', [AdminsController::class, 'createKey']);

    // Committee routes
    Route::apiResource('committees', CommitteeController::class);
    Route::post('committees/{committee}/photo', [CommitteeController::class, 'storePhoto']);
    Route::put('committees/{committee}/photo', [CommitteeController::class, 'updatePhoto']);
    Route::post('committees/{committee}/generate-key', [CommitteeController::class, 'createKey']);

    Route::apiResource('employees', EmployeesController::class);
    Route::post('employees/{employee}/photo', [EmployeesController::class, 'storePhoto']);
    Route::put('employees/{employee}/photo', [EmployeesController::class, 'updatePhoto']);
    Route::post('employees/{employee}/generate-key', [EmployeesController::class, 'createKey']);

    Route::apiResource('applications', ApplicationsController::class)->except(['store']);
});

Route::post('applications', [ApplicationsController::class, 'store']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('wilayas', function () {
        return response()->json(["wilayas" => Wilaya::with('dairas')->get()], 200);
    });
});



require __DIR__ . '/auth.php';
