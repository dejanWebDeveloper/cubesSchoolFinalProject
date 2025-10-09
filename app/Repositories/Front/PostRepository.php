<?php

namespace App\Repositories\Front;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Cache;

class PostRepository
{
    /**
     * index page
     */
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

    /**
     * blog pages
     */
    public function getBlogPosts()
    {
        $page = request('page', 1);
        $cacheKey = "blogPosts_page_{$page}";
        $blogPosts = Cache::remember($cacheKey, 600, function () {
            return Post::standardRequest()
                ->withCount('comments')
                ->paginate(12);
        });
        Post::addCacheKeyToIndex($cacheKey);
        return $blogPosts;
    }

    public function getAuthorPosts($authorId)
    {
        $page = request('page', 1);
        $cacheKey = "authorPosts_{$authorId}_page_{$page}";
        $authorPosts = Cache::remember($cacheKey, 400, function () use ($authorId) {
            return Post::with('author')
                ->withCount('comments')
                ->where('author_id', $authorId)
                ->where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);
        return $authorPosts;
    }

    public function getCategoryPosts($categoryId)
    {
        $page = request('page', 1);
        $cacheKey = "categoryPosts_{$categoryId}_page_{$page}";
        $categoryPosts = Cache::remember($cacheKey, 400, function () use ($categoryId) {
            return Post::with('category')
                ->withCount('comments')
                ->where('category_id', $categoryId)
                ->where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);
        return $categoryPosts;
    }

    public function getSinglePost($id, $slug)
    {
        $cacheKey = "singlePost_{$id}";
        $singlePost = Cache::remember($cacheKey, 300, function () use ($id, $slug) {
            return Post::withCount(['comments' => function ($query) {
                $query->where('enable', 1);
            }])->where('slug', $slug)
                ->where('id', $id)
                ->where('enable', 1)
                ->firstOrFail();
        });
        Post::addCacheKeyToIndex($cacheKey);
        return $singlePost;
    }
    public function incrementPostViews($post)
    {
        $sessionKey = 'post_' . $post->id . '_viewed';
        if (!session()->has($sessionKey)) {
            $post->increment('views');
            session([$sessionKey => true]);
        }
    }

    public function getPrevPost($id, $singlePost)
    {
        $cacheKeyPrev = "prevPost_{$id}";
        $prevPost = Cache::remember($cacheKeyPrev, 300, function () use ($id, $singlePost) {
            return Post::where('id', '<', $singlePost->id)
                ->where('enable', 1)
                ->orderBy('id', 'desc')
                ->first();
        });
        Post::addCacheKeyToIndex($cacheKeyPrev);
        return $prevPost;
    }

    public function getNextPost($id, $singlePost)
    {
        $cacheKeyNext = "nextPost_{$id}";
        $nextPost = Cache::remember($cacheKeyNext, 300, function () use ($id, $singlePost) {
            return Post::where('id', '>', $singlePost->id)
                ->where('enable', 1)
                ->orderBy('id', 'asc')
                ->first();
        });
        Post::addCacheKeyToIndex($cacheKeyNext);
        return $nextPost;
    }

    public function getPostComments($singlePost)
    {
        return PostComment::where('post_id', $singlePost->id)
            ->where('enable', 1)
            ->orderBy('created_at', 'asc')
            ->get();
    }
    public function storeComment(array $data)
    {
        $data['enable'] = 1;

        $comment = new PostComment();
        $comment->fill($data);
        $comment->save();
        Post::clearBlogCacheForPost($data['post_id']);
        return $comment;
    }
    public function getTagPosts($id, $tag)
    {
        $page = request('page', 1);
        $cacheKey = "tagPosts_{$id}_page_{$page}";
        $tagPosts = Cache::remember($cacheKey, 400, function () use ($tag) {
            return $tag->posts()
                ->with('category', 'author')
                ->withCount('comments')
                ->where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);
        return $tagPosts;
    }
    public function getPostsResult($query)
    {
        $page = request('page', 1);

        $cacheKey = "searchResults_" . md5($query) . "_page_{$page}";
        $results = Cache::remember($cacheKey, 300, function () use ($query) {
            return Post::withCount('comments')
                ->where('heading', 'like', '%' . $query . '%')
                ->orWhere('preheading', 'like', '%' . $query . '%')
                ->orWhere('text', 'like', '%' . $query . '%')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);
        return $results;
    }
}
