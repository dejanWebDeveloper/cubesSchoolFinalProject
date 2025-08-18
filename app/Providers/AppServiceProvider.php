<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
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
        $latestFooterPosts = Post::standardRequest()
            ->limit(3)
            ->get();
        view()->share(compact('latestFooterPosts'));

        $latestPostsForBlogPartial = Post::standardRequest()
            ->withCount('comments')
            ->skip(3)
            ->take(3)
            ->get();
        view()->share(compact('latestPostsForBlogPartial'));

        $allCategoriesForBlogPartial = Category::all();
        view()->share(compact('allCategoriesForBlogPartial'));

        $allTagsForBlogPartial = Tag::all();
        view()->share(compact('allTagsForBlogPartial'));
    }
}
