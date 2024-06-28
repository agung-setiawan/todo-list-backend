<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [
    \App\Http\Controllers\Api\AuthController::class, 'register'
]);

Route::post('/login', [
    \App\Http\Controllers\Api\AuthController::class, 'login'
]);

Route::middleware('auth:sanctum')->group(function () {	
    Route::get('/user', [
        \App\Http\Controllers\Api\AuthController::class, 'user'
    ]);
	
    Route::get('/my/todo-list', [
        \App\Http\Controllers\Api\TodoLists::class, 'index'
    ]);

    Route::post('/create/todo-list', [
        \App\Http\Controllers\Api\TodoLists::class, 'store'
    ]);

    Route::post('/update/todo-list', [
        \App\Http\Controllers\Api\TodoLists::class, 'update'
    ]);
	
    Route::get('/show/todo-list/{id}', [
        \App\Http\Controllers\Api\TodoLists::class, 'show'
    ]);
	
    Route::delete('/remove/todo-list/{id}', [
        \App\Http\Controllers\Api\TodoLists::class, 'destroy'
    ]);		

    Route::post('/logout', [
        \App\Http\Controllers\Api\AuthController::class, 'logout'
    ]);
});

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/