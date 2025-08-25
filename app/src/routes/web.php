<?php



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

Route::get('TOP/index', [AccountController::class, 'index']);  // アカウント一覧ページ

//ユーザー

Route::prefix('users')->name('users.')->controller(UsersController::class)
    ->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('show/{id}', 'show')->name('show');
    });
//ユーザー所持アイテム一覧


//アイテム




//Route::get('score/index', [AccountController::class, 'score']);


