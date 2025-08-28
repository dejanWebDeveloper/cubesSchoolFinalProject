<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.post_pages.posts_page');
    }
    public function addPost()
    {
        return view('admin.post_pages.add_post_form');
    }
}
