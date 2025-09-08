<?php

// ルーティング設定。このページを見にきたら、どのコントローラーや画面を見せるかという地図的なやつ。お疲れ様です！

// 1、「web.php」にて、ルーティングをまとめられているので、商品一覧、商品詳細、商品編集、商品登録などのルーティングは個別で記述をお願いします。

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 認証必須のグループ
Route::middleware('auth')->group(function () {
    // 一覧
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // 新規作成フォーム
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    // 登録処理
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    // 詳細
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // 編集フォーム
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    // 更新処理
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // 削除処理
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// ルート（ホーム）は一覧にリダイレクト
Route::get('/', fn () => redirect()->route('products.index'));

// 認証系は既存の auth.php を読み込み
require __DIR__.'/auth.php';

