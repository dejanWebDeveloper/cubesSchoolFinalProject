<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostRepository
{
    public function getImportantPosts()
    {
        $cacheKeyImportant = "importantPost";
        $importantPosts = Cache::remember($cacheKeyImportant, 1200, function () {
            return Post::standardRequest()
                ->withCount('comments')
                ->where('important', 1)
                ->limit(3)
                ->get();

        });
        Post::addCacheKeyToIndex($cacheKeyImportant);
        return $importantPosts;
    }
    public function getLatestPosts()
    {
        $cacheKeyLatest = "latestPostsSlider";
        $latestPostsSlider = Cache::remember($cacheKeyLatest, 1200, function () {
            return Post::standardRequest()
                ->where('important', 0)
                ->limit(12)
                ->get();
        });
        Post::addCacheKeyToIndex($cacheKeyLatest);
        return $latestPostsSlider;
    }


}
