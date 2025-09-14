<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            ->addColumn('actions', fn($row) => view('admin.post_pages.partials.actions', compact('row'))
            )
            ->rawColumns(['photo', 'actions', 'important'])
            ->toJson();
    }

    public function storePost()
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:20', 'max:255'],
            'preheading' => ['required', 'string', 'min:50', 'max:500'],
            'category_id' => ['numeric', 'exists:categories,id'],
            'author_id' => ['required', 'numeric', 'exists:authors,id'],
            'tags' => ['required', 'array', 'min:2'],
            'tags.*' => ['required', 'numeric', 'exists:tags,id'],
            'first-photo' => ['file', 'mimes:jpeg,png,jpg', 'max:1000'],
            'second-photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000'],
            'text' => ['required', 'string', 'min:20', 'max:1000']
        ]);
        $data['slug'] = Str::slug($data['heading']);
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
            $this->savePhoto($photo, $newPost, 'photo');
        }
        if (request()->hasFile('second-photo')) { //if has file
            $additionalPhoto = request()->file('second-photo'); //save file to $photo
            //helper methode
            $this->savePhoto($additionalPhoto, $newPost, 'additional_photo');
        }

        session()->put('system_message', 'Post Added Successfully');
        return redirect()->route('admin_posts_page');
    }

    public function savePhoto($photo, $post, $field)
    {
        // Generate unique filename
        $photoName = $post->id . '_' . $field . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

        // Delete old photo if exists
        if ($post->$field) {
            $oldPath = 'photo/' . $post->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Save new photo to storage
        $path = $photo->storeAs('photo', $photoName, 'public');

        // Update DB
        $post->$field = basename($path);
        $post->save();
    }

    public function deletePhoto($post, $field)
    {
        if (!$post->$field) return false;

        $path = 'photo/' . $post->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $post->$field = null;
        $post->save();

        return true;
    }


    public function deletePost()
    {
        $data = request()->validate([
            'post_for_delete_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $post = Post::findOrFail($data['post_for_delete_id']);
        $post->delete();
        //delete data from post_tags table
        $post->tags()->sync([]);
        return response()->json(['success' => 'Post Deleted Successfully']);
    }

    public function editPost($id, $slug)
    {
        $postForEdit = Post::where('slug', $slug)->where('id', $id)->firstOrFail();
        $categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();
        return view('admin.post_pages.edit_post_page', compact(
            'postForEdit',
            'categories',
            'authors',
            'tags'
        ));
    }

    public function storeEditedPost(Post $postForEdit, Request $request)
    {
        $data = request()->validate([
            'heading' => ['required', 'string', 'min:20', 'max:255'],
            'preheading' => ['required', 'string', 'min:50', 'max:500'],
            'category_id' => ['numeric', 'exists:categories,id'],
            'author_id' => ['required', 'numeric', 'exists:authors,id'],
            'tags' => ['required', 'array', 'min:2'],
            'tags.*' => ['required', 'numeric', 'exists:tags,id'],
            'first-photo' => ['file', 'mimes:jpeg,png,jpg', 'max:1000'],
            'second-photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000'],
            'text' => ['required', 'string', 'min:20', 'max:1000']
        ]);
        $data['slug'] = Str::slug($data['heading']);
        $data['enable'] = 1;
        $data['important'] = 0;
        $data['created_at'] = now();
        $data['text'] = strip_tags($data['text']);
        $postForEdit->fill($data)->save();
        //table tags
        $postForEdit->tags()->sync($data['tags']);

        //saving photo
        if ($request->hasFile('first-photo')) {
            $this->deletePhoto($postForEdit, 'photo');
            $this->savePhoto($request->file('first-photo'), $postForEdit, 'photo');
        }

        if ($request->hasFile('second-photo')) {
            $this->deletePhoto($postForEdit, 'additional_photo');
            $this->savePhoto($request->file('second-photo'), $postForEdit, 'additional_photo');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            if ($postForEdit->photo) {
                Storage::disk('public')->delete('photo/' . $postForEdit->photo);
                $postForEdit->photo = null;
                $postForEdit->save();
            }
        }
        if ($request->has('delete_photo2') && $request->delete_photo2) {
            if ($postForEdit->additional_photo) {
                Storage::disk('public')->delete('photo/' . $postForEdit->additional_photo);
                $postForEdit->additional_photo = null;
                $postForEdit->save();
            }
        }

        session()->put('system_message', 'Post Edited Successfully');
        return redirect()->route('admin_posts_page');
    }
    public function disablePost()
    {
        $data = request()->validate([
            'post_for_disable_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $post = Post::findOrFail($data['post_for_disable_id']);
        $post->enable = 0;
        $post->save();
        return response()->json(['success' => 'Post Disabled Successfully']);
    }
    public function enablePost()
    {
        $data = request()->validate([
            'post_for_enable_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $post = Post::findOrFail($data['post_for_enable_id']);
        $post->enable = 1;
        $post->save();
        return response()->json(['success' => 'Post Enabled Successfully']);
    }
    public function unimportantPost()
    {
        $data = request()->validate([
            'post_be_unimportant_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $post = Post::findOrFail($data['post_be_unimportant_id']);
        $post->important = 0;
        $post->save();
        return response()->json(['success' => 'Post Change Status Successfully']);
    }
    public function importantPost()
    {
        $data = request()->validate([
            'post_be_important_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $post = Post::findOrFail($data['post_be_important_id']);
        $post->important = 1;
        $post->save();
        return response()->json(['success' => 'Post Change Status Successfully']);
    }
    public function displayComments()
    {
        return view('admin.comment_pages.comments_page');
    }
    public function datatableComments(Request $request)
    {
        $query = PostComment::query();

}
