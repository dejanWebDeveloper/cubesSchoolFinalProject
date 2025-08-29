<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();
        return view('admin.post_pages.posts_page', compact('categories' , 'authors','tags'));
    }
    public function addPost()
    {
        return view('admin.post_pages.add_post_form');
    }
    public function datatable(Request $request)
    {
        $query = Post::withCount('comments')->with(['category', 'author']);

        if ($request->heading) {
            $query->where('heading', 'like', "%{$request->heading}%");
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->author_id) {
            $query->where('author_id', $request->author_id);
        }
        if ($request->enable !== null && $request->enable !== '') {
            $query->where('enable', $request->enable);
        }
        if ($request->important !== null && $request->important !== '') {
            $query->where('important', $request->important);
        }
        if ($request->filled('tags_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags_id);
            });
        }



        return DataTables::of($query)
            ->addColumn('photo', fn($row) =>
                "<img src='" . e($row->imageUrl()) . "' width='100' class='img-rounded' />"
            )
            ->addColumn('heading', fn($row) => $row->heading)
            ->editColumn('enable', fn($row) => $row->enable ? 'Active' : 'Disable')
            ->editColumn('important', fn($row) =>
            $row->important
                ? 'Yes'
                : 'No'
            )
            ->addColumn('category', fn($row) => $row->category?->name)
            ->addColumn('comments', fn($row) => $row->comments_count)
            ->addColumn('views', fn($row) => $row->views)
            ->addColumn('author', fn($row) => $row->author?->name)
            ->editColumn('created_at', fn($row) =>
            $row->created_at?->format('d/m/Y H:i:s')
            )
            ->addColumn('actions', fn($row) =>
            view('admin.post_pages.actions', compact('row'))
            )
            ->rawColumns(['photo', 'actions', 'important'])
            ->toJson();
    }


}
