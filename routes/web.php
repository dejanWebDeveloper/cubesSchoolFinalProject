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
        Route::post('/ajax-category-datatable', [\App\Http\Controllers\Admin\CategoryController::class, 'datatable'])->name('datatable');
        Route::post('/store-category', [\App\Http\Controllers\Admin\CategoryController::class, 'storeCategory'])->name('store_category');
        Route::post('/delete-category', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteCategory'])->name('delete_category');
        Route::get('/edit-category/{slug}', [\App\Http\Controllers\Admin\CategoryController::class, 'editCategory'])->name('edit_category_page');
        Route::post('/store-edited-category/{categoryForEdit}', [\App\Http\Controllers\Admin\CategoryController::class, 'storeEditedCategory'])->name('edit_category');

    });

    Route::prefix('/users')->name('users_')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Admin\UserController::class, 'userProfile'])->name('user_profile');
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('page');
        Route::get('/add-user', [\App\Http\Controllers\Admin\UserController::class, 'addUser'])->name('add_user');
        Route::post('/ajax-user-datatable', [\App\Http\Controllers\Admin\UserController::class, 'datatable'])->name('datatable');
        Route::post('/store-user', [\App\Http\Controllers\Admin\UserController::class, 'storeUser'])->name('store_user');
        Route::post('/enable-user', [\App\Http\Controllers\Admin\UserController::class, 'enableUser'])->name('enable_user');
        Route::post('/disable-user', [\App\Http\Controllers\Admin\UserController::class, 'disableUser'])->name('disable_user');
        Route::prefix('/edit-user')->name('edit_user_')->group(function (){
            Route::get('/',[\App\Http\Controllers\Admin\UserController::class, 'editUser'])->name('page');
            Route::get('/password', [\App\Http\Controllers\Admin\UserController::class, 'editUserPassword'])->name('password_page');
            Route::post('/store-edited-user', [\App\Http\Controllers\Admin\UserController::class, 'storeEditedUser'])->name('data');
            Route::post('/store-edited-user-password', [\App\Http\Controllers\Admin\UserController::class, 'storeEditedUserPassword'])->name('password');
            Route::get('/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPasswordPage'])->name('reset_password_page');
            Route::post('/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetUserPassword'])->name('reset_user_password');
        });

    });

    Route::prefix('/tags')->name('tags_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TagController::class, 'index'])->name('page');
        Route::get('/add-tag', [\App\Http\Controllers\Admin\TagController::class, 'addTag'])->name('add_tag');
        Route::post('/ajax-tag-datatable', [\App\Http\Controllers\Admin\TagController::class, 'datatable'])->name('datatable');
        Route::post('/store-tag', [\App\Http\Controllers\Admin\TagController::class, 'storeTag'])->name('store_tag');
        Route::post('/delete-tag', [\App\Http\Controllers\Admin\TagController::class, 'deleteTag'])->name('delete_tag');
        Route::get('/edit-tag/{slug}', [\App\Http\Controllers\Admin\TagController::class, 'editTag'])->name('edit_tag_page');
        Route::post('/store-edited-tag/{tagForEdit}', [\App\Http\Controllers\Admin\TagController::class, 'storeEditedTag'])->name('edit_tag');

    });

    Route::prefix('/authors')->name('authors_')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AuthorController::class, 'index'])->name('page');
        Route::get('/add-author', [\App\Http\Controllers\Admin\AuthorController::class, 'addAuthor'])->name('add_author');
        Route::post('/ajax-author-datatable', [\App\Http\Controllers\Admin\AuthorController::class, 'datatable'])->name('datatable');
        Route::post('/store-author', [\App\Http\Controllers\Admin\AuthorController::class, 'storeAuthor'])->name('store_author');
        Route::post('/delete-author', [\App\Http\Controllers\Admin\AuthorController::class, 'deleteAuthor'])->name('delete_author');
        Route::get('/edit-author/{slug}', [\App\Http\Controllers\Admin\AuthorController::class, 'editAuthor'])->name('edit_author_page');
        Route::post('/store-edited-author/{authorForEdit}', [\App\Http\Controllers\Admin\AuthorController::class, 'storeEditedAuthor'])->name('edit_author');

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

    Route::prefix('/homepage-slider')->name('sliders_')->group(function (){
        Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'sliderHomepage'])->name('page');
        Route::get('/add-slider-data', [\App\Http\Controllers\Admin\IndexController::class, 'addSliderData'])->name('add_slider');
        Route::post('/ajax-slider-datatable', [\App\Http\Controllers\Admin\IndexController::class, 'datatable'])->name('datatable');
        Route::post('/store-slider', [\App\Http\Controllers\Admin\IndexController::class, 'storeSlider'])->name('store_slider');
        Route::post('/delete-slider', [\App\Http\Controllers\Admin\IndexController::class, 'deleteSlider'])->name('delete_slider');
        Route::get('/edit-slider/{id}', [\App\Http\Controllers\Admin\IndexController::class, 'editSlider'])->name('edit_slider_page');
        Route::post('/store-edited-slider/{sliderForEdit}', [\App\Http\Controllers\Admin\IndexController::class, 'storeEditedSlider'])->name('edit_slider');

    });
});


Auth::routes();

