<?php

// このページを見にきたら、どのコントローラーや画面を見せるかという地図的なやつ
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//  /products のところに来たらProductControllerが「・新規登録・編集・削除」など全部やってくれる
// Route::resource('products',〜はproductsっていう商品ページの全部の道を一気に作る
// ->middleware('auth') はちゃんとログインしてる人しか見れない
Route::resource('products', ProductController::class)->middleware('auth');

// ホーム(/)に来た人は自動で /products の一覧ページへ
Route::get('/', function () {
    return redirect()->route('products.index');
});

// /dashboard に来たら dashboard.blade.php を見せる
// auth → ログインしてないと入れない
// verified → メール確認OKな人だけ入れる
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 「ログインしてる人だけ」可能
// - /profile → プロフィールの編集画面
// - PATCH /profile → プロフィールの更新処理
// - DELETE /profile → プロフィールの削除処理
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


// ログイン」や「新規登録」のルールが書かれた別の地図（auth.php）を読み込む。
require __DIR__.'/auth.php';

// MEMO
// 🏠 / ─→ products.index  (ProductController) ─→ の画面
// 🔑 /login  ─→ Auth\AuthenticatedSessionController@create ─→ ログイン画面
// 🧑 /register  ─→ Auth\RegisteredUserController@create  ─→ 新規登録画面

// 商品周り（全てログイン必須）
// GET    /products              ─→ index   ─→ 
// GET    /products/create       ─→ create  ─→ 新規登録フォーム
// POST   /products              ─→ store   ─→ 登録処理(保存)
// GET    /products/{id}         ─→ show    ─→ 詳細画面
// GET    /products/{id}/edit    ─→ edit    ─→ 編集フォーム
// PUT    /products/{id}         ─→ update  ─→ 更新処理(保存)
// DELETE /products/{id}         ─→ destroy ─→ 削除処理

// 全部 ProductController が担当。Route::resource('products', ProductController::class)->middleware('auth'); が一気に作ってる

// ダッシュボードとプロフィール（全てログイン必須）
// GET    /dashboard  ─→ 画面: resources/views/dashboard.blade.php
// GET    /profile    ─→ ProfileController@edit    ─→ プロフィール編集画面
// PATCH  /profile    ─→ ProfileController@update  ─→ 更新処理
// DELETE /profile    ─→ ProfileController@destroy ─→ 削除処理

// 人がURLを開く
//    │
//    ├─ /           → (リダイレクト) → /products → ProductController@index → products/index.blade.php
//    ├─ /login      → Auth…@create   → auth/login.blade.php
//    ├─ /register   → Auth…@create   → auth/register.blade.php
//    └─ /products/○ → 各メソッドへ   → 対応する画面

// ルートの定義場所は主に
// routes/web.php（商品・ダッシュボード・プロフィール）
// routes/auth.php（ログイン・登録）
// 画面は resources/views/... にある（Bladeファイル）

