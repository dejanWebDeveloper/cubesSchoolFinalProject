<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SliderData;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function index()
    {
        $cacheKeySlider = "sliderData";
        $sliderData = Cache::remember($cacheKeySlider, 1200, function (){
            return SliderData::where('status', 1)->orderBy('position', 'asc')->get();
        });
        $cacheKeyImportant = "importantPost";
        $importantPosts = Cache::remember($cacheKeyImportant, 1200, function (){
            return Post::standardRequest()
                ->withCount('comments')
                ->where('important', 1)
                ->limit(3)
                ->get();
        });
        $cacheKeyLatest = "latestPostsSlider";
        $latestPostsSlider = Cache::remember($cacheKeyLatest, 1200, function (){
            return Post::standardRequest()
                ->where('important', 0)
                ->limit(12)
                ->get();
        });
        Post::addCacheKeyToIndex($cacheKeySlider);
        Post::addCacheKeyToIndex($cacheKeyImportant);
        Post::addCacheKeyToIndex($cacheKeyLatest);
        return view('front.index_page.index', compact(
            'sliderData',
            'importantPosts',
            'latestPostsSlider'
        ));
    }
}
