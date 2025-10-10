<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AuthorRepository;
use App\Models\Author;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\PhotoService;

class AuthorController extends Controller
{
    protected $authors;
    protected $photoService;
    public function __construct(AuthorRepository $authors, PhotoService $photoService)
    {
        $this->authors = $authors;
        $this->photoService = $photoService;
    }

    public function index()
    {
        return view('admin.author_pages.authors_page');
    }

    public function addAuthor()
    {
        return view('admin.author_pages.add_author_form');
    }

    public function datatable(Request $request, AuthorRepository $authors)
    {

        $query = $authors->getFilteredAuthors($request->only(['name', 'email']));

        return DataTables::of($query)
            ->addColumn('profile_photo', fn($row) => "<img src='" . e($row->authorImageUrl()) . "' width='100' class='img-rounded' />"
            )
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('email', fn($row) => $row->email)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s')
            )
            ->addColumn('actions', fn($row) => view('admin.author_pages.partials.actions', compact('row'))
            )
            ->rawColumns(['profile_photo', 'actions'])
            ->toJson();
    }

    public function storeAuthor()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'unique:authors,email'],
            'first-photo' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);

        $newAuthor = $this->authors->createAuthor($data);
        //saving photo
        if (request()->hasFile('first-photo')) {
            $this->photoService->save(request()->file('first-photo'), $newAuthor, 'profile_photo');
        }

        session()->put('system_message', 'Author Added Successfully');
        return redirect()->route('admin_authors_page');
    }

    public function deleteAuthor()
    {
        $data = request()->validate([
            'author_for_delete_id' => ['required', 'numeric', 'exists:authors,id'],
        ]);
        $this->authors->deleteAuthor($data);
        return response()->json(['success' => 'Author Deleted Successfully']);
    }

    public function editAuthor($id, $slug)
    {
        $authorForEdit = Author::where('slug', $slug)->where('id', $id)->firstOrFail();
        return view('admin.author_pages.edit_author_page', compact(
            'authorForEdit'
        ));
    }

    public function storeEditedAuthor(Author $authorForEdit, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email'],
            'first-photo' => ['file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $authorForEdit = $this->authors->editAuthor($authorForEdit, $data);
        //saving photo and delete old photo
        if ($request->hasFile('first-photo')) {
            $this->photoService->delete($authorForEdit, 'profile_photo');
            $this->photoService->save($request->file('first-photo'), $authorForEdit, 'profile_photo');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->photoService->delete($authorForEdit, 'profile_photo');
        }
        session()->put('system_message', 'Authors data Edited Successfully');
        return redirect()->route('admin_authors_page');
    }
}
