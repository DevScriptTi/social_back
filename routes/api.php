<?php

use App\Http\Controllers\Api\Main\ApplicationsController;
use App\Http\Controllers\Api\Main\SocialController;
use App\Http\Controllers\Api\Users\EmployeesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json(["user" => $request->user()->load('key.keyable.photo')], 200);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('employees', EmployeesController::class);
    Route::post('employees/{employee}/photo', [EmployeesController::class, 'storePhoto']);
    Route::put('employees/{employee}/photo', [EmployeesController::class, 'updatePhoto']);
    Route::post('employees/{employee}/generate-key', [EmployeesController::class, 'createKey']);
    Route::apiResource('applications', ApplicationsController::class)->except(['store', 'show']);
    
    Route::apiResource('socials', SocialController::class);
    Route::get('socials/{social}/evalute', [SocialController::class, 'evaluate']);
    Route::get('socials/{social}/applications', [SocialController::class, 'getApplications']);
});

Route::get('applications/{application}', [ApplicationsController::class, 'show']);

Route::middleware(['guest:sanctum'])->group(function () {
    Route::post('applications', [ApplicationsController::class, 'store']);
    Route::post('applications/{application}/applicant', [ApplicationsController::class, 'applicant']);
    Route::post('applications/{application}/professional', [ApplicationsController::class, 'professional']);
    Route::post('applications/{application}/housing', [ApplicationsController::class, 'housing']);
    Route::post('applications/{application}/health', [ApplicationsController::class, 'health']);
    Route::post('applications/{application}/files', [ApplicationsController::class, 'files']);
    
});





require __DIR__ . '/auth.php';
