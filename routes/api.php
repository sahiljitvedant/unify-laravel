<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
use App\Http\Controllers\API\GymMembershipApiController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\FaqApiController;
use App\Http\Controllers\Api\AppInfoController;

// Route::apiResource('memberships', GymMembershipApiController::class);
// Route::get('/memberships', [GymMembershipApiController::class, 'index']);
Route::middleware('throttle:memberships')
    ->get('/memberships', [GymMembershipApiController::class, 'index']);
Route::get('/blogs/{id}', [BlogApiController::class, 'show']);
Route::get('/faqs', [FaqApiController::class, 'index']);

use App\Http\Controllers\Api\TrainerApiController;

Route::post('/trainers', [TrainerApiController::class, 'store']);

Route::get('/app/info', [AppInfoController::class, 'appInfo']);