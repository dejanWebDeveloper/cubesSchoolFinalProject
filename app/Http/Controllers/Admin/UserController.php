<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user_pages.users_page');
    }
    public function addUser()
    {
        return view('admin.user_pages.add_user_form');
    }
}
