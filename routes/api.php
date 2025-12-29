<?php

use App\Http\Controllers\Api\AssetApiController;
use App\Http\Controllers\Api\AssignmentApiController;
use App\Http\Controllers\Api\IncidentApiController;
use App\Http\Controllers\Api\MaintenanceApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes here are prefixed with /api and protected by API key.
| Send X-API-Key header with every request.
|
*/

Route::middleware('api-key')->prefix('v1')->group(function () {

    // Assets
    Route::get('assets', [AssetApiController::class, 'index']);
    Route::get('assets/{asset}', [AssetApiController::class, 'show']);
    Route::post('assets', [AssetApiController::class, 'store']);
    Route::put('assets/{asset}', [AssetApiController::class, 'update']);
    Route::delete('assets/{asset}', [AssetApiController::class, 'destroy']);

    // Assignments
    Route::post('assets/{asset}/assign', [AssignmentApiController::class, 'assign']);
    Route::post('assets/{asset}/return', [AssignmentApiController::class, 'return']);
    Route::get('assignments', [AssignmentApiController::class, 'index']);

    // Maintenance
    Route::get('maintenance', [MaintenanceApiController::class, 'index']);
    Route::post('maintenance', [MaintenanceApiController::class, 'store']);

    // Incidents
    Route::get('incidents', [IncidentApiController::class, 'index']);
    Route::get('incidents/{incident}', [IncidentApiController::class, 'show']);
    Route::post('incidents', [IncidentApiController::class, 'store']);
    Route::put('incidents/{incident}', [IncidentApiController::class, 'update']);
});
