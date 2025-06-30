<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UserItemController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/{error_id?}', [AuthController::class, 'index']); //ログイン画面
Route::post('login', [AuthController::class, 'login']);         //ログイン処理
Route::post('logout', [AuthController::class, 'logout']);         //ログアウト処理

Route::get('TOP/index', [AccountController::class, 'index']);  // アカウント一覧ページ

//ユーザー

Route::prefix('users')->name('users.')->controller(UsersController::class)
    ->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('show/{id}', 'show')->name('show');
    });
//ユーザー所持アイテム一覧
Route::prefix('user_item')->name('user_item.')->controller(UserItemController::class)
    ->group(function () {
        Route::get('index', 'index')->name('index');

    });

//アイテム
Route::prefix('item')->name('item.')->controller(ItemsController::class)
    ->middleware(AuthMiddleware::class)->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('create/{errors?}', 'create')->name('create');//登録画面
        Route::post('store', 'store')->name('store');//登録処理
        Route::get('result', 'result')->name('result');
        Route::post('destroy/{id}', 'destroy')->name('destroy');
        Route::post('edit/{id}', 'edit')->name('edit');
        Route::get('edit/{id}/{errors?}', 'edit')->name('edit_redirect');
        Route::post('update', 'update')->name('update');
    });



//Route::get('score/index', [AccountController::class, 'score']);


