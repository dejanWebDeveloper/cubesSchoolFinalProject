<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        //four categories for footer
        $footerCategories = Category::orderBy('priority', 'asc')
            ->limit(4)
            ->get();
        view()->share(compact('footerCategories'));
        //three latest post
        $latestFooterPosts = Post::with('category', 'author', 'tags')
            ->where('enable', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        view()->share(compact('latestFooterPosts'));

    }
}
