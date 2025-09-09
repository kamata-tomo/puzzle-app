<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::get('users/index',
//    [UserController::class, 'index'])
//    ->name('users.index');
Route::get('users/show',
    [UserController::class, 'show'])
    ->middleware('auth:sanctum')->name('users.show');
Route::post('users/store',
    [UserController::class, 'store'])
    ->name('users.store');
Route::post('users/update',
    [UserController::class, 'update'])
    ->middleware('auth:sanctum')->name('users.update');
Route::get('users/show_title',
    [UserController::class, 'show_title'])
    ->middleware('auth:sanctum')->name('users.show_title');
Route::post('users/title-registration',
    [UserController::class, 'title_registration'])
    ->middleware('auth:sanctum')->name('users.title_registration');
Route::post('users/friend-request',
    [UserController::class, 'friend_request'])
    ->middleware('auth:sanctum')->name('users.friend_request');//リクエスト登録


Route::get('tests',[TestController::class, 'tests']);
