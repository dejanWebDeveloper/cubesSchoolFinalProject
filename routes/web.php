<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index_page');
Route::get('/blog', [\App\Http\Controllers\Front\BlogController::class, 'blog'])->name('blog_page');
Route::get('/blog-author', [\App\Http\Controllers\Front\BlogController::class, 'blogAuthor'])->name('blog_author_page');
Route::get('/blog-category', [\App\Http\Controllers\Front\BlogController::class, 'blogCategory'])->name('blog_category_page');
Route::get('/blog-post', [\App\Http\Controllers\Front\BlogController::class, 'blogPost'])->name('blog_post_page');
Route::get('/blog-search', [\App\Http\Controllers\Front\BlogController::class, 'blogSearch'])->name('blog_search_page');
Route::get('/blog-tag', [\App\Http\Controllers\Front\BlogController::class, 'blogTag'])->name('blog_tag_page');
