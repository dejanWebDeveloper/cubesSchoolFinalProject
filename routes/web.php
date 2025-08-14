<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index_page');
Route::get('/blog', [\App\Http\Controllers\Front\BlogController::class, 'blog'])->name('blog_page');
Route::get('/blog-author', [\App\Http\Controllers\Front\BlogController::class, 'blogAuthor'])->name('blog_author_page');
