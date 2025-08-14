<?php

// auth.phpはログインまわり＆パスワードまわりのルートをまとめた地図
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route::middleware('guest')
// まだログインしてない人だけが通れる道（ログイン済みだと通らない！）
Route::middleware('guest')->group(function () {

// 目的・URL・方法・コントローラ＠メソッド・表示画面

    // 新規登録フォームを開く・/register・GET・RegisteredUserController@create・登録画面を表示
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // 新規登録を送信する・/register・POST・RegisteredUserController@store・ユーザーを作ってログイン
    Route::post('register', [RegisteredUserController::class, 'store']);

    // ログイン画面を開く・/login・GET・AuthenticatedSessionController@create・ログイン画面を表示
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // ログインを送信する・/login・POST・AuthenticatedSessionController@store・認証してOKならログイン
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // パスワード再設定メール画面・/forgot-password・GET・PasswordResetLinkController@create・メール入力画面
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // 再設定メールを送信・/forgot-password・POST・PasswordResetLinkController@store・メール送信処理
    Route::post('forgot-password', [c::class, 'store'])
        ->name('password.email');

    // 新しいパスワード入力画面・/reset-password/{token}・GET・NewPasswordController@create・新パスワード入力
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // 新しいパスワードを保存・/reset-password・POST・NewPasswordController@store・パスワード更新
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});


// Route::middleware('auth')
// ログイン済みの人だけ通れる
Route::middleware('auth')->group(function () {

    // 目的・URL・方法・コントローラ＠メソッド・表示画面

    // メール確認を促す画面・/verify-email・GET・EmailVerificationPromptController・メール確認画面
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // メール確認リンクの受け取り・/verify-email/{id}/{hash}・GET・VerifyEmailController・本人確認＆承認（署名＆回数制限あり）
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // 確認メールをもう一度送る・email/verification-notification・POST・EmailVerificationNotificationController@store・送信回数制限あり（throttle）
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // パスワード再入力画面・/confirm-password・GET・ConfirmablePasswordController@show・大事な操作の前に再確認
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // 再入力の送信・/confirm-password・POST・ConfirmablePasswordController@store・OKなら通過
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // パスワード変更・/password・PUT・PasswordController@update・いまの→新しいに変更
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // ログアウト・/logout・POST・AuthenticatedSessionController@destroy・セッション破棄→ログアウト
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

// MEMO
// GET:ページを開く POST・PUT：フォームで送る（登録・更新・ログアウトなど）

// /logout は POST じゃないとダメ（リンク直打ちGETはエラーになる）
// <form method="POST" action="{{ route('logout') }}">
//     @csrf
//     <button type="submit">ログアウト</button>
// </form>

// それぞれに対応する Blade（例：resources/views/auth/login.blade.php）が必要。

