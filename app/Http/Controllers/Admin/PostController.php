<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();
        return view('admin.post_pages.posts_page', compact('categories', 'authors', 'tags'));
    }

    public function addPost()
    {
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();
        return view('admin.post_pages.add_post_form', compact('categories', 'authors', 'tags'));
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
            ->addColumn('photo', fn($row) => "<img src='" . e($row->imageUrl()) . "' width='100' class='img-rounded' />"
            )
            ->addColumn('heading', fn($row) => $row->heading)
            ->editColumn('enable', fn($row) => $row->enable ? 'Active' : 'Disable')
            ->editColumn('important', fn($row) => $row->important
                ? 'Yes'
                : 'No'
            )
            ->addColumn('category', fn($row) => $row->category?->name)
            ->addColumn('comments', fn($row) => $row->comments_count)
            ->addColumn('views', fn($row) => $row->views)
            ->addColumn('author', fn($row) => $row->author?->name)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s')
            )
            ->addColumn('actions', fn($row) => view('admin.post_pages.actions', compact('row'))
            )
            ->rawColumns(['photo', 'actions', 'important'])
            ->toJson();
    }

    public function storePost()
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:20', 'max:255'],
            'preheading' => ['required', 'string', 'min:50', 'max:500'],
            'category_id' => ['nullable', 'numeric', 'exists:categories,id'],
            'author_id' => ['required', 'numeric', 'exists:authors,id'],
            'tags' => ['required', 'array', 'min:2'],
            'tags.*' => ['required', 'numeric', 'exists:tags,id'],
            'first-photo' => ['file', 'mimes:jpeg,png,jpg', 'max:1000'],
            'second-photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000'],
            'text' => ['required', 'string', 'min:20', 'max:1000']
        ]);
        $data['enable'] = 1;
        $data['important'] = 0;
        $data['created_at'] = now();
        $data['text'] = strip_tags($data['text']);
        $newPost = new Post();
        $newPost->fill($data)->save();
        //table tags
        $newPost->tags()->sync($data['tags']);

        //saving photo
        if (request()->hasFile('first-photo')) { //if has file
            $photo = request()->file('first-photo'); //save file to $photo
            //helper methode
            $this->savePhoto($photo, $newPost);
        }
        if (request()->hasFile('second-photo')) { //if has file
            $additionalPhoto = request()->file('second-photo'); //save file to $photo
            //helper methode
            $this->savePhoto($additionalPhoto, $newPost);
        }

        session()->put('system_message', 'Post Added Successfully');
        return redirect()->route('admin_posts_page');
    }

    public function savePhoto($photo, $newPost)
    {
        $photoName = $newPost->id . '_' . time() . '.' . $photo->getClientOriginalExtension();

        // save file to storage/app/public/photo
        $path = $photo->storeAs('photo', $photoName, 'public');

        // snimi ime fajla u bazu
        if (!$newPost->photo) {
            $newPost->photo = basename($path);
        } else {
            $newPost->additional_photo = basename($path);
        }
        $newPost->save();
    }


}
