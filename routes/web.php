<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index_page');

Route::get('/contact', [\App\Http\Controllers\Front\ContactController::class, 'contact'])->name('contact_page');
Route::post('send-email', [\App\Http\Controllers\Front\ContactController::class, 'sendEmail'])->name('send_email');

Route::prefix('/blog')->name('blog_')->group(function () {
    Route::get('/', [\App\Http\Controllers\Front\BlogController::class, 'blog'])->name('page');
    Route::get('/author/{name}', [\App\Http\Controllers\Front\BlogController::class, 'blogAuthor'])->name('author_page');
    Route::get('/category/{name}', [\App\Http\Controllers\Front\BlogController::class, 'blogCategory'])->name('category_page');
    Route::get('/post/{heading}', [\App\Http\Controllers\Front\BlogController::class, 'blogPost'])->name('post_page');
    Route::post('/store-comment', [\App\Http\Controllers\Front\BlogController::class, 'storeComment'])->name('store_comment');
    Route::get('/search', [\App\Http\Controllers\Front\BlogController::class, 'blogSearch'])->name('search_page');
    Route::get('/tag/{name}', [\App\Http\Controllers\Front\BlogController::class, 'blogTag'])->name('tag_page');
});

