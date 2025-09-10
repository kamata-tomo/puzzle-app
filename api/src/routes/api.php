<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ユーザー関連API
Route::prefix('users')->group(function () {

    // ユーザー情報参照
    Route::get('show', [UserController::class, 'show'])
        ->middleware('auth:sanctum')
        ->name('users.show');

    // ユーザー登録
    Route::post('store', [UserController::class, 'store'])
        ->name('users.store');

    // ユーザー情報更新
    Route::post('update', [UserController::class, 'update'])
        ->middleware('auth:sanctum')
        ->name('users.update');

    // 称号取得状況参照
    Route::get('show-title', [UserController::class, 'show_title'])
        ->middleware('auth:sanctum')
        ->name('users.show_title');

    // 称号登録
    Route::post('store-title', [UserController::class, 'store_title'])
        ->middleware('auth:sanctum')
        ->name('users.store_title');

    // フレンドリクエスト登録
    Route::post('store-friend-request', [UserController::class, 'store_friend_request'])
        ->middleware('auth:sanctum')
        ->name('users.store_friend_request');

    // フレンドリクエスト参照
    Route::get('show-friend-request', [UserController::class, 'show_friend_request'])
        ->middleware('auth:sanctum')
        ->name('users.show_friend_request');

    // フレンド承認後登録
    Route::post('store-friend', [UserController::class, 'store_friend'])
        ->middleware('auth:sanctum')
        ->name('users.store_friend');

    // フレンド参照
    Route::get('show-friend', [UserController::class, 'show_friend'])
        ->middleware('auth:sanctum')
        ->name('users.show_friend');

    // スタミナ自動回復
    Route::post('stamina-auto-recovery', [UserController::class, 'stamina_auto_recovery'])
        ->middleware('auth:sanctum')
        ->name('users.stamina_auto_recovery');

    // reason_idによるスタミナ増減
    Route::post('stamina-changes-by-reasons', [UserController::class, 'stamina_changes_by_reasons'])
        ->middleware('auth:sanctum')
        ->name('users.stamina_changes_by_reasons');
    //フレンドによるスタミナ回復
    Route::post('provider-stamina', [UserController::class, 'provider_stamina'])
        ->middleware('auth:sanctum')
        ->name('users.provider_stamina');
});

Route::prefix('users')->group(function () {

});
Route::get('tests',[TestController::class, 'tests']);
