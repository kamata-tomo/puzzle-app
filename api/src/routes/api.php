<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('users/index',
    [UserController::class, 'index'])
    ->name('users.index');
Route::get('users/{user_id}',
    [UserController::class, 'show'])
    ->name('users.show');
Route::post('users/store',
    [UserController::class, 'store'])
    ->name('users.store');
Route::post('users/update',
    [UserController::class, 'update'])
    ->middleware('auth:sanctum')->name('users.update');


