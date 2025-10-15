<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SliderDataController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('index_page');

Route::get('/contact', [\App\Http\Controllers\Front\ContactController::class, 'contact'])->name('contact_page');
Route::post('send-email', [\App\Http\Controllers\Front\ContactController::class, 'sendEmail'])->name('send_email');
Route::get('/reset-forgotten-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'forgottenPassword'])->name('forgotten_password');
Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'resetForgottenPassword'])->name('reset_forgotten_password');

Route::prefix('/blog')->name('blog_')->group(function () {
    Route::get('/', [\App\Http\Controllers\Front\BlogController::class, 'blog'])->name('page');
    Route::get('/author/{id}/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogAuthor'])->name('author_page');
    Route::get('/category/{id}/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogCategory'])->name('category_page');
    Route::get('/post/{id}/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogPost'])->name('post_page');
    Route::post('/store-comment', [\App\Http\Controllers\Front\BlogController::class, 'storeComment'])->name('store_comment');
    Route::get('/search', [\App\Http\Controllers\Front\BlogController::class, 'blogSearch'])->name('search_page');
    Route::get('/tag/{id}/{slug}', [\App\Http\Controllers\Front\BlogController::class, 'blogTag'])->name('tag_page');
});
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::resource('index', IndexController::class)->only('index');

    Route::resource('categories', CategoryController::class)->except(['show', 'edit']);
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::post('/ajax-category-datatable', [\App\Http\Controllers\Admin\CategoryController::class, 'datatable'])->name('datatable');
        Route::get('/edit-category/{id}/{slug}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
    });
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Admin\UserController::class, 'userProfile'])->name('profile');
        Route::post('/ajax-user-datatable', [\App\Http\Controllers\Admin\UserController::class, 'datatable'])->name('datatable');
        Route::post('/enable-user', [\App\Http\Controllers\Admin\UserController::class, 'enableUser'])->name('enable.user');
        Route::post('/disable-user', [\App\Http\Controllers\Admin\UserController::class, 'disableUser'])->name('disable.user');
        Route::prefix('/edit-user')->name('edit.user.')->group(function (){
            Route::get('/',[\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('page');
            Route::get('/password', [\App\Http\Controllers\Admin\UserController::class, 'editUserPassword'])->name('password.page');
            Route::post('/store-edited-user-password', [\App\Http\Controllers\Admin\UserController::class, 'storeEditedUserPassword'])->name('password');
            Route::get('/reset-forgotten-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPasswordPage'])->name('reset.password.page');
            Route::post('/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetUserPassword'])->name('reset.user.password');
        });
    });
    Route::resource('users', UserController::class)->except(['show', 'edit'. 'destroy']);

    Route::resource('tags', TagController::class)->except(['show', 'edit', 'update']);
    Route::prefix('/tags')->name('tags.')->group(function () {
        Route::post('/ajax-tag-datatable', [\App\Http\Controllers\Admin\TagController::class, 'datatable'])->name('datatable');
    });
    Route::resource('authors', AuthorController::class)->except(['show', 'edit']);
    Route::prefix('/authors')->name('authors.')->group(function () {
        Route::post('/ajax-author-datatable', [\App\Http\Controllers\Admin\AuthorController::class, 'datatable'])->name('datatable');
        Route::get('/edit-author/{id}/{slug}', [\App\Http\Controllers\Admin\AuthorController::class, 'edit'])->name('edit');
    });
    Route::resource('posts', PostController::class)->except(['show', 'edit']);
    Route::prefix('/posts')->name('posts.')->group(function () {
        Route::post('/ajax-post-datatable', [\App\Http\Controllers\Admin\PostController::class, 'datatable'])->name('datatable');
        Route::get('/edit-post/{id}/{slug}', [\App\Http\Controllers\Admin\PostController::class, 'edit'])->name('edit');
        Route::post('/enable-post', [\App\Http\Controllers\Admin\PostController::class, 'enablePost'])->name('enable.post');
        Route::post('/disable-post', [\App\Http\Controllers\Admin\PostController::class, 'disablePost'])->name('disable.post');
        Route::post('/important-post', [\App\Http\Controllers\Admin\PostController::class, 'importantPost'])->name('be.important.post');
        Route::post('/unimportant-post', [\App\Http\Controllers\Admin\PostController::class, 'unimportantPost'])->name('be.unimportant.post');
    });
    Route::resource('sliders', SliderDataController::class)->except(['show', 'edit']);
    Route::prefix('/homepage-slider')->name('sliders.')->group(function (){
        Route::post('/ajax-slider-datatable', [\App\Http\Controllers\Admin\SliderDataController::class, 'datatable'])->name('datatable');
        Route::get('/edit-slider/{id}/{slug}', [\App\Http\Controllers\Admin\SliderDataController::class, 'edit'])->name('edit');
        Route::post('/enable-slider', [\App\Http\Controllers\Admin\SliderDataController::class, 'enableSlider'])->name('enable.slider');
        Route::post('/disable-slider', [\App\Http\Controllers\Admin\SliderDataController::class, 'disableSlider'])->name('disable.slider');
        Route::post('/slider/sort', [\App\Http\Controllers\Admin\SliderDataController::class, 'sort'])->name('slider.sort');
    });

    Route::prefix('/comments')->name('comments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PostController::class, 'displayComments'])->name('index');
        Route::post('/ajax-comment-datatable', [\App\Http\Controllers\Admin\PostController::class, 'datatableComments'])->name('datatable.comments');
        Route::post('/disable-comment', [\App\Http\Controllers\Admin\PostController::class, 'disableComment'])->name('disable.comment');
        Route::post('/enable-comment', [\App\Http\Controllers\Admin\PostController::class, 'enableComment'])->name('enable.comment');

    });

});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();
