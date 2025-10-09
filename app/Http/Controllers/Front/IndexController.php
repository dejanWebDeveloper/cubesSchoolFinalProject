<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Front\PostRepository;
use App\Repositories\Front\SliderDataRepository;

class IndexController extends Controller
{
    protected $posts;
    protected $sliderData;

    public function __construct(PostRepository $posts, SliderDataRepository $sliderData)
    {
        $this->posts = $posts;
        $this->sliderData = $sliderData;
    }

    public function index()
    {
        $sliderData = $this->sliderData->getSliderData();

        $importantPosts = $this->posts->getImportantPosts();

        $latestPostsSlider = $this->posts->getLatestPosts();

        return view('front.index_page.index', compact(
            'sliderData',
            'importantPosts',
            'latestPostsSlider'
        ));
    }
}
