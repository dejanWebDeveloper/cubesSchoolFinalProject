<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SliderData;

class IndexController extends Controller
{
    public function index()
    {
        $sliderData = SliderData::where('status', 1)->get();
        $importantPosts = Post::standardRequest()
            ->withCount('comments')
            ->where('important', 1)
            ->limit(3)
            ->get();
        $latestPostsSlider = Post::standardRequest()
            ->where('important', 0)
            ->limit(12)
            ->get();
        return view('front.index_page.index', compact(
            'sliderData',
            'importantPosts',
            'latestPostsSlider'
        ));
    }
}
