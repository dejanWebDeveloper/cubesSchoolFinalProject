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
            ->get();
        return view('front.index_page.index', compact(
            'importantPosts'
        ));
    }
}
