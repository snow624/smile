<?php
use App\Http\Controllers\ProductController;

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/search', [ProductController::class, 'searchAjax'])->name('products.search');

    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::post('/products', [ProductController::class,'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class,'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class,'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class,'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class,'destroy'])->name('products.destroy');
});

require __DIR__.'/auth.php';
