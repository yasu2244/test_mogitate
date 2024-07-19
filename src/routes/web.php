<?php

use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // 商品一覧表示
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search'); // 商品検索
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // 商品登録フォーム表示
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store'); // 商品登録
Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.show'); // 商品詳細
Route::put('/products/{product_id}/update', [ProductController::class, 'update'])->name('products.update'); // 商品更新
Route::delete('/products/{product_id}/delete', [ProductController::class, 'destroy'])->name('products.destroy'); // 商品削除