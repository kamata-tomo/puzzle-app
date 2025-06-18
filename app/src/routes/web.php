<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UserItemController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/{error_id?}', [AuthController::class, 'index']); //ログイン画面
Route::post('login', [AuthController::class, 'login']);         //ログイン処理
Route::post('logout', [AuthController::class, 'logout']);         //ログアウト処理

Route::get('TOP/index', [AuthController::class, 'index']); // アカウント一覧ページ

//ユーザー
Route::get('Users/index', [UsersController::class, 'index']);
//ユーザー所持アイテム一覧
Route::get('UserItems/index', [UserItemController::class, 'index']);
//アイテム
Route::get('Item/index', [ItemsController::class, 'index']);


Route::get('Item/create', [ItemsController::class, 'create']);//登録画面
Route::post('Item/store', [ItemsController::class, 'store']);//登録処理
Route::post('Item/result', [ItemsController::class, 'result'])->name('Item.result');



//Route::get('score/index', [AccountController::class, 'score']);


