<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return view('admin.author_pages.authors_page');
    }
    public function addAuthor()
    {
        return view('admin.author_pages.add_author_form');
    }
}
