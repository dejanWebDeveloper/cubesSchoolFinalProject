<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use App\Repositories\Front\PostRepository;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    public function blog()
    {
        $blogPosts = $this->posts->getBlogPosts();
        /*$page = request('page', 1);
        $cacheKey = "blogPosts_page_{$page}";
        $blogPosts = Cache::remember($cacheKey, 600, function () {
            return Post::standardRequest()
                ->withCount('comments')
                ->paginate(12);
        });
        Post::addCacheKeyToIndex($cacheKey);*/

        return view('front.blog_pages.blog_page.blog_page', compact('blogPosts'));
    }


    public function blogAuthor($id, $slug)
    {
        $author = Author::where('slug', $slug)->where('id', $id)->firstOrFail();
        $authorPosts = $this->posts->getAuthorPosts($author->id);
        /*$page = request('page', 1);
        $cacheKey = "authorPosts_page_{$page}";
        $authorPosts = Cache::remember($cacheKey, 400, function () use ($author) {
            return Post::with('author')
                ->withCount('comments')
                ->where('author_id', $author->id)
                ->where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);*/
        return view('front.blog_pages.blog_author_page.blog_author_page', compact(
            'authorPosts',
            'author'
        ));
    }

    public function blogCategory($id, $slug)
    {
        $category = Category::where('slug', $slug)->where('id', $id)->firstOrFail();
        $categoryPosts = $this->posts->getCategoryPosts($category->id);
        /*$page = request('page', 1);
        $cacheKey = "categoryPosts_page_{$page}";
        $categoryPosts = Cache::remember($cacheKey, 400, function () use ($category) {
            return Post::with('category')
                ->withCount('comments')
                ->where('category_id', $category->id)
                ->where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);*/
        return view('front.blog_pages.blog_category_page.blog_category_page', compact(
            'category',
            'categoryPosts'
        ));
    }

    public function blogPost($id, $slug)
    {
        $singlePost = $this->posts->getSinglePost($id, $slug);
        $this->posts->incrementPostViews($singlePost);
        $singlePostTags = $singlePost->tags()->get();
        $prevPost = $this->posts->getPrevPost($id, $singlePost);
        $nextPost = $this->posts->getNextPost($id, $singlePost);
        $comments = $this->posts->getPostComments($singlePost);
        return view('front.blog_pages.blog_post_page.blog_post_page', compact(
            'singlePost',
            'singlePostTags',
            'prevPost',
            'nextPost',
            'comments'
        ));
    }

    public function storeComment(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'email' => ['required', 'string', 'email:rfc,dns'], // stronger email validation
            'comment' => ['required', 'string', 'min:5', 'max:500'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
            'g-recaptcha-response' => ['required', new ReCaptcha()]
        ]);
        $newComment = $this->posts->storeComment($data);
        /*$data['enable'] = 1;

        $newComment = new PostComment();
        $newComment->fill($data);
        $newComment->save();
        Post::clearBlogCacheForPost($data['post_id']);*/
        return response()->json([
            'message' => 'Your comment has been submitted successfully!',
            'comment' => $newComment // optional: return comment if you want to append it via JS
        ], 201);
    }

    public function blogTag($id, $slug)
    {
        $tag = Tag::where('slug', $slug)->where('id', $id)->firstOrFail();
        $tagPosts = $this->posts->getTagPosts($id, $tag);
        /*$page = request('page', 1);
        $cacheKey = "tagPosts_page_{$page}";
        $tagPosts = Cache::remember($cacheKey, 400, function () use ($tag) {
            return $tag->posts()
                ->with('category', 'author')
                ->withCount('comments')
                ->where('enable', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        });
        Post::addCacheKeyToIndex($cacheKey);*/
        return view('front.blog_pages.blog_tag_page.blog_tag_page', compact(
            'tag',
            'tagPosts'
        ));
    }

    public function blogSearch(Request $request)
    {
        $query = $request->input('search');
        $results = $this->posts->getPostsResult($query);
        return view('front.blog_pages.blog_search_page.blog_search_page', compact(
            'results',
            'query'
        ));
    }

}
