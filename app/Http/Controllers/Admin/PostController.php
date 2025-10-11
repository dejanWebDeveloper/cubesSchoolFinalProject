<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use App\Repositories\Admin\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use App\Services\PhotoService;

class PostController extends Controller
{
    protected $content;
    protected $photoService;

    public function __construct(PostRepository $content, PhotoService $photoService)
    {
        $this->content = $content;
        $this->photoService = $photoService;
    }

    public function index()
    {
        $postContent = $this->content->postContent();
        return view('admin.post_pages.posts_page', compact('postContent'));
    }

    public function addPost()
    {
        $addPostContent = $this->content->postContent();
        return view('admin.post_pages.add_post_form', compact('addPostContent'));
    }

    public function datatable(Request $request)
    {
        $query = $this->content->dataTable($request);

        return DataTables::of($query)
            ->addColumn('photo', fn($row) => "<img src='" . e($row->imageUrl()) . "' width='100' class='img-rounded' />"
            )
            ->addColumn('heading', fn($row) => $row->heading)
            ->editColumn('enable', fn($row) => $row->enable
                ? '<span class="badge badge-success">Yes</span>'
                : '<span class="badge badge-danger">No</span>')
            ->editColumn('important', fn($row) => $row->important
                ? '<span class="badge badge-success">Yes</span>'
                : '<span class="badge badge-danger">No</span>'
            )
            ->addColumn('category', fn($row) => $row->category?->name)
            ->addColumn('comments', fn($row) => $row->comments_count)
            ->addColumn('views', fn($row) => $row->views)
            ->addColumn('author', fn($row) => $row->author?->name)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s')
            )
            ->addColumn('actions', fn($row) => view('admin.post_pages.partials.actions', compact('row'))
            )
            ->rawColumns(['photo', 'actions', 'important', 'enable'])
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
            'text' => ['required', 'string', 'min:20', 'max:1000']
        ]);
        $newPost = $this->content->savePost($data);
        //saving photo
        if (request()->hasFile('first-photo')) { //if has file
            $photo = request()->file('first-photo'); //save file to $photo
            //helper methode
            $this->photoService->savePostPhoto($photo, $newPost, 'photo');
        }
        session()->put('system_message', 'Post Added Successfully');
        return redirect()->route('admin_posts_page');
    }

    public function deletePost()
    {
        $data = request()->validate([
            'post_for_delete_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $this->content->deletePost($data);
        PostComment::where('post_id', $data['post_for_delete_id'])->delete();
        return response()->json(['success' => 'Post Deleted Successfully']);
    }

    public function editPost($id, $slug)
    {
        $postForEdit = $this->content->editPost($id, $slug);
        /*$categories = Category::all();
        $authors = Author::all();
        $tags = Tag::all();*/
        $contentForEdit = $this->content->postContent();
        return view('admin.post_pages.edit_post_page', compact(
            'postForEdit',
            'contentForEdit'
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
            'text' => ['required', 'string', 'min:20', 'max:1000']
        ]);
        $postForEdit = $this->content->saveEditedPost($data, $postForEdit);

        //saving photo
        if ($request->hasFile('first-photo')) {
            $this->photoService->deletePostPhoto($postForEdit, 'photo');
            $this->photoService->savePostPhoto($request->file('first-photo'), $postForEdit, 'photo');
        }

        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->content->deletePhotoJS($postForEdit);
        }

        session()->put('system_message', 'Post Edited Successfully');
        return redirect()->route('admin_posts_page');
    }

    public function disablePost()
    {
        $data = request()->validate([
            'post_for_disable_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $this->content->disableOnePost($data);
        return response()->json(['success' => 'Post Disabled Successfully']);
    }

    public function enablePost()
    {
        $data = request()->validate([
            'post_for_enable_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $this->content->enableOnePost($data);
        return response()->json(['success' => 'Post Enabled Successfully']);
    }

    public function unimportantPost()
    {
        $data = request()->validate([
            'post_be_unimportant_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $this->content->unimportant($data);
        return response()->json(['success' => 'Post Change Status Successfully']);
    }

    public function importantPost()
    {
        $data = request()->validate([
            'post_be_important_id' => ['required', 'numeric', 'exists:posts,id'],
        ]);
        $this->content->important($data);
        return response()->json(['success' => 'Post Change Status Successfully']);
    }

    public function displayComments()
    {
        return view('admin.comment_pages.comments_page');
    }

    public function datatableComments(Request $request)
    {
        $query = $this->content->dataTableComments($request);

        return DataTables::of($query)
            ->addColumn('comment', fn($row) => $row->comment)
            ->addColumn('post', fn($row) => $row->post->heading)
            ->addColumn('post_id', fn($row) => $row->post_id)
            ->editColumn('enable', fn($row) => $row->enable
                ? '<span class="badge badge-success">Yes</span>'
                : '<span class="badge badge-danger">No</span>')
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s'))
            ->addColumn('actions', fn($row) => view('admin.comment_pages.partials.actions', compact('row'))
            )
            ->rawColumns(['enable', 'actions'])
            ->toJson();
    }

    public function disableComment()
    {
        $data = request()->validate([
            'comment_for_disable_id' => ['required', 'numeric', 'exists:post_comments,id'],
        ]);
        $this->content->disableOneComment($data);
        return response()->json(['success' => 'Comment Disabled Successfully']);
    }

    public function enableComment()
    {
        $data = request()->validate([
            'comment_for_enable_id' => ['required', 'numeric', 'exists:post_comments,id'],
        ]);
        $this->content->enableOneComment($data);
        return response()->json(['success' => 'Comment Enabled Successfully']);
    }
}
