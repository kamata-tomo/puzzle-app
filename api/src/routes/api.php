<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\StageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('users/index',
    [UserController::class, 'index'])
    ->name('users.index');
Route::get('users/show',
    [UserController::class, 'show'])
    ->middleware('auth:sanctum')->name('users.show');
Route::post('users/store',
    [UserController::class, 'store'])
    ->name('users.store');
Route::post('users/update',
    [UserController::class, 'update'])
    ->middleware('auth:sanctum')->name('users.update');
Route::get('users/ShowTitle',
    [UserController::class, 'ShowTitle'])
    ->middleware('auth:sanctum')->name('users.ShowTitle');
Route::post('users/TitleRegistration',
    [UserController::class, 'TitleRegistration'])
    ->middleware('auth:sanctum')->name('users.TitleRegistration');

