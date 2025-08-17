<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        $importantPosts = Post::with('category', 'author', 'tags')
            ->where('important', 1)
            ->where('enable', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        $latestPostsSlider = Post::with('category', 'author', 'tags')
            ->where('important', 0)
            ->where('enable', 1)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();
        return view('front.index_page.index', compact(
            'importantPosts',
            'latestPostsSlider'
        ));
    }
}
