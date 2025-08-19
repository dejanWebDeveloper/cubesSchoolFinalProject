<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog()
    {
        $blogPosts = Post::standardRequest()
            ->withCount('comments')
            ->paginate(12);
        return view('front.blog_pages.blog_page.blog_page', compact('blogPosts'));
    }

    public function blogAuthor($name)
    {
        $author = Author::where('name', $name)->firstOrFail();
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

    public function blogCategory($name)
    {
        $category = Category::where('name', $name)->firstOrFail();
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

    public function blogPost()
    {

        return view('front.blog_pages.blog_post_page.blog_post_page');
    }

    /*public function blogSearch()
    {
        return view('front.blog_pages.blog_search_page.blog_search_page');
    }*/
    public function blogTag()
    {
        return view('front.blog_pages.blog_tag_page.blog_tag_page');
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
