<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('categories')) {
            $footerCategories = Category::orderBy('priority', 'asc')
                ->take(4)
                ->get();
            view()->share(compact('footerCategories'));
        }
        //three latest post
        if (Schema::hasTable('posts')) {
            $latestFooterPosts = Post::standardRequest()
                ->take(3)
                ->get();
            view()->share(compact('latestFooterPosts'));
        }
        if (Schema::hasTable('posts')) {
            $latestPostsForBlogPartial = Post::standardRequest()
                ->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])
                ->withCount('comments')
                ->orderByDesc('views')
                ->take(3)
                ->get();
            view()->share(compact('latestPostsForBlogPartial'));
        }
        if (Schema::hasTable('categories')) {
            $allCategoriesForBlogPartial = Category::withCount(['posts' => function ($query) {
                $query->orderBy('priority', 'asc')
                ->where('enable', 1);
            }])->get();
            view()->share(compact('allCategoriesForBlogPartial'));
        }
        if (Schema::hasTable('tags')) {
            $allTagsForBlogPartial = Tag::withCount(['posts as enabled_posts_count' => function ($query) {
                $query->where('enable', true);
            }])
                ->orderByDesc('enabled_posts_count')
                ->get();

            view()->share(compact('allTagsForBlogPartial'));
        }
    }
}
