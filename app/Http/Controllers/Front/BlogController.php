<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog()
    {
        return view('front.blog_pages.blog_page.blog_page');
    }
}
