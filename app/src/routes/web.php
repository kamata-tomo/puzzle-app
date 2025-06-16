<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/{error_id?}', [AuthController::class, 'index']); //ログイン画面
Route::post('login', [AuthController::class, 'login']);         //ログイン処理
Route::post('logout', [AuthController::class, 'logout']);         //ログアウト処理

Route::get('accounts/index', [AccountController::class, 'index']); // アカウント一覧ページ
Route::get('score/index', [AccountController::class, 'score']);


