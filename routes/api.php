<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users Routes
Route::get('/user', [UserController::class, 'list']);
Route::post('/user', [UserController::class, 'create']);

//Account Routes
Route::post('/account', [AccountController::class, 'create']);
Route::get('/account/{id}', [AccountController::class, 'list']);

//Transaction Routes
Route::post('/transaction', [TransactionController::class, 'create']);