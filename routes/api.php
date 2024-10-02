<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatFileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1.0.0')->group(function() 
{

    Route::post('register', [AuthController::class, 'register'] );
    Route::post('login', [AuthController::class, 'login'] );

    Route::post('otp-code',[AuthController::class, 'checkOtpCode'] );

    Route::middleware(['auth:sanctum'])->group(function() {
        Route::get('users', [UserController::class, 'index'] );
        Route::get('logout',  [AuthController::class, 'logout'] );
    });



     Route::post('group', [GroupController::class, 'Groupregister']);



    // Route::get('/groups', [GroupController::class, 'index']);
    Route::get('/groups', [GroupController::class, 'index']);



    Route::post('/groups/{groupId}/invite',[GroupController::class, 'Invite'] );

    
    Route::post('upload-file/{id}',[FileController::class, 'file'] );


    Route::get('/group/{groupId}/files', [FileController::class,'getFiles']);

        // Route::get('telecharge/{id}', [FileController::class, 'telecharge']);
        // Route::get('/groups', [GroupController::class, 'getGroupByName']);




} );
