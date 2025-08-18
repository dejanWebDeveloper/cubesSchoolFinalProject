<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SliderData;

class IndexController extends Controller
{
    public function index()
    {
        $sliderData = SliderData::all();
        $importantPosts = Post::with('category', 'author', 'tags')
            ->withCount('comments')
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
            'sliderData',
            'importantPosts',
            'latestPostsSlider'
        ));
    }
}
