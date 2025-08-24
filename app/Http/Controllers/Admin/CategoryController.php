<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public  function  index()
    {
        return view('admin.category_pages.categories_page');
    }

    public  function  addCategory()
    {
        return view('admin.category_pages.add_category_form');
    }
}
