<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.tag_pages.tags_page');
    }
    public function addTag()
    {
        return view('admin.tag_pages.add_tag_form');
    }
}
