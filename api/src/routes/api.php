<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::get('users/index',
//    [UserController::class, 'index'])
//    ->name('users.index');
//ユーザー情報参照
Route::get('users/show',
    [UserController::class, 'show'])
    ->middleware('auth:sanctum')->name('users.show');
//ユーザー登録
Route::post('users/store',
    [UserController::class, 'store'])
    ->name('users.store');
//ユーザー情報更新
Route::post('users/update',
    [UserController::class, 'update'])
    ->middleware('auth:sanctum')->name('users.update');
//称号取得状況参照
Route::get('users/show-title',
    [UserController::class, 'show_title'])
    ->middleware('auth:sanctum')->name('users.show_title');
//称号登録
Route::post('users/store-title',
    [UserController::class, 'store_title'])
    ->middleware('auth:sanctum')->name('users.store_title');
//フレンドリクエスト登録
Route::post('users/store-friend-request',
    [UserController::class, 'store_friend_request'])
    ->middleware('auth:sanctum')->name('users.store_friend_request');
//フレンドリクエスト参照
Route::get('users/show-friend-request',
    [UserController::class, 'show_friend_request'])
    ->middleware('auth:sanctum')->name('users.show_friend_request');
//フレンド承認後登録
Route::post('users/store-friend',
    [UserController::class, 'store_friend'])
    ->middleware('auth:sanctum')->name('users.store_friend');
//フレンド参照
Route::get('users/show-friend',
    [UserController::class, 'show_friend'])
    ->middleware('auth:sanctum')->name('users.show_friend');
//スタミナ参照

//スタミナ増減

Route::get('tests',[TestController::class, 'tests']);
