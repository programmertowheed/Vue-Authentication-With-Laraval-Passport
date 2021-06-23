<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', function (){
        return response()->json( ['message' => 'Unauthorised access'], 401 );
    })->name('login');

    Route::middleware('auth:api')->group(function(){
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user/{id}', [AuthController::class, 'userShow']);

        Route::resource('/blog', BlogController::class)->except('create', 'edit');
    });
});

