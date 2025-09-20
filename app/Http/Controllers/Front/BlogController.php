<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function blog()
    {
        $blogPosts = Post::standardRequest()
            ->withCount('comments')
            ->paginate(12);
        return view('front.blog_pages.blog_page.blog_page', compact('blogPosts'));
    }

    public function blogAuthor($id, $slug)
    {
        $author = Author::where('slug', $slug)->where('id', $id)->firstOrFail();
        $authorPosts = Post::with('author')
            ->withCount('comments')
            ->where('author_id', $author->id)
            ->where('enable', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('front.blog_pages.blog_author_page.blog_author_page', compact(
            'authorPosts',
            'author'
        ));
    }

    public function blogCategory($id, $slug)
    {
        $category = Category::where('slug', $slug)->where('id', $id)->firstOrFail();
        $categoryPosts = Post::with('category')
            ->withCount('comments')
            ->where('category_id', $category->id)
            ->where('enable', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('front.blog_pages.blog_category_page.blog_category_page', compact(
            'category',
            'categoryPosts'
        ));
    }

    public function blogPost($id, $slug)
    {
        $singlePost = Post::withCount(['comments'=>function ($query) {
            $query->where('enable', 1);
        }])->where('slug', $slug)
            ->where('id', $id)
            ->where('enable', 1)
            ->firstOrFail();
        //increment views
        $sessionKey = 'post_' . $singlePost->id . '_viewed';
        if (!session()->has($sessionKey)) {
            $singlePost->increment('views');
            session([$sessionKey => true]);
        }
        $singlePostTags = $singlePost->tags()->get();
        $prevPost = Post::where('id', '<', $singlePost->id)
            ->where('enable', 1)
            ->orderBy('id', 'desc')
            ->first();
        $nextPost = Post::where('id', '>', $singlePost->id)
            ->where('enable', 1)
            ->orderBy('id', 'asc')
            ->first();
        $comments = PostComment::where('post_id', $singlePost->id)
            ->where('enable', 1)
            ->orderBy('created_at', 'asc')
            ->get();
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

        $data['enable'] = 1;

        $newComment = new PostComment();
        $newComment->fill($data);
        $newComment->save();

        return response()->json([
            'message' => 'Your comment has been submitted successfully!',
            'comment' => $newComment // optional: return comment if you want to append it via JS
        ], 201);
    }


    public function blogTag($id, $slug)
    {
        $tag = Tag::where('slug', $slug)->where('id', $id)->firstOrFail();
        $tagPosts = $tag->posts()
            ->with('category', 'author')
            ->withCount('comments')
            ->where('enable', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('front.blog_pages.blog_tag_page.blog_tag_page', compact(
            'tag',
            'tagPosts'
        ));
    }

    public function blogSearch(Request $request)
    {
        $query = $request->input('search');

        $results = Post::withCount('comments')
            ->where('heading', 'like', '%' . $query . '%')
            ->orWhere('preheading', 'like', '%' . $query . '%')
            ->orWhere('text', 'like', '%' . $query . '%')
            ->paginate(4);

        return view('front.blog_pages.blog_search_page.blog_search_page', compact(
            'results',
            'query'
        ));
    }

}
