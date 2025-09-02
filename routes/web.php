<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index_page');

Route::get('/contact', [\App\Http\Controllers\Front\ContactController::class, 'contact'])->name('contact_page');
Route::post('send-email', [\App\Http\Controllers\Front\ContactController::class, 'sendEmail'])->name('send_email');

Route::prefix('/blog')->name('blog_')->group(function () {
    Route::get('/', [\App\Http\Controllers\Front\BlogController::class, 'blog'])->name('page');
    Route::get('/author/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogAuthor'])->name('author_page');
    Route::get('/category/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogCategory'])->name('category_page');
    Route::get('/post/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogPost'])->name('post_page');
    Route::post('/store-comment', [\App\Http\Controllers\Front\BlogController::class, 'storeComment'])->name('store_comment');
    Route::get('/search', [\App\Http\Controllers\Front\BlogController::class, 'blogSearch'])->name('search_page');
    Route::get('/tag/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogTag'])->name('tag_page');
});
Route::middleware('auth')->prefix('admin')->name('admin_')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index_page');

    Route::prefix('/categories')->name('categories_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('page');
        Route::get('/add-category', [\App\Http\Controllers\Admin\CategoryController::class, 'addCategory'])->name('add_category');
    });

    Route::prefix('/users')->name('users_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('page');
        Route::get('/add-user', [\App\Http\Controllers\Admin\UserController::class, 'addUser'])->name('add_user');
    });

    Route::prefix('/tags')->name('tags_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TagController::class, 'index'])->name('page');
        Route::get('/add-tag', [\App\Http\Controllers\Admin\TagController::class, 'addTag'])->name('add_tag');
    });

    Route::prefix('/authors')->name('authors_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AuthorController::class, 'index'])->name('page');
        Route::get('/add-author', [\App\Http\Controllers\Admin\AuthorController::class, 'addAuthor'])->name('add_author');
    });

    Route::prefix('/posts')->name('posts_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('page');
        Route::get('/add-post', [\App\Http\Controllers\Admin\PostController::class, 'addPost'])->name('add_post');
        Route::post('/ajax-post-datatable', [\App\Http\Controllers\Admin\PostController::class, 'datatable'])->name('datatable');
        Route::post('/store-post', [\App\Http\Controllers\Admin\PostController::class, 'storePost'])->name('store_post');
        Route::post('/delete-post', [\App\Http\Controllers\Admin\PostController::class, 'deletePost'])->name('delete_post');
        Route::get('/edit-post/{slug}', [\App\Http\Controllers\Admin\PostController::class, 'editPost'])->name('edit_post_page');
        Route::post('/store-edited-post/{postForEdit}', [\App\Http\Controllers\Admin\PostController::class, 'storeEditedPost'])->name('edit_post');

    });
});


Auth::routes();

