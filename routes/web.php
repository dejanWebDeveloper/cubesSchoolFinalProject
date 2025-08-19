<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index_page');

Route::get('/contact', [\App\Http\Controllers\Front\ContactController::class, 'contact'])->name('contact_page');

Route::prefix('/blog')->name('blog_')->group(function () {
    Route::get('/', [\App\Http\Controllers\Front\BlogController::class, 'blog'])->name('page');
    Route::get('/author/{name}', [\App\Http\Controllers\Front\BlogController::class, 'blogAuthor'])->name('author_page');
    Route::get('/category/{name}', [\App\Http\Controllers\Front\BlogController::class, 'blogCategory'])->name('category_page');
    Route::get('/post', [\App\Http\Controllers\Front\BlogController::class, 'blogPost'])->name('post_page');
    Route::get('/search', [\App\Http\Controllers\Front\BlogController::class, 'blogSearch'])->name('search_page');
    Route::get('/tag/{name}', [\App\Http\Controllers\Front\BlogController::class, 'blogTag'])->name('tag_page');
});
