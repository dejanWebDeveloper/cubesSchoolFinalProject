<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Repositories\Admin\AuthorRepository;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AuthorController extends Controller
{
    protected $authors;
    protected $photoService;

    public function __construct(AuthorRepository $authors, PhotoService $photoService)
    {
        $this->authors = $authors;
        $this->photoService = $photoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.author_pages.authors_page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.author_pages.add_author_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
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
        return redirect()->route('admin.authors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $slug)
    {
        $authorForEdit = Author::where('slug', $slug)->where('id', $id)->firstOrFail();
        return view('admin.author_pages.edit_author_page', compact(
            'authorForEdit'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $authorForEdit)
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
        return redirect()->route('admin.authors.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $this->authors->deleteAuthor(['author_for_delete_id' => $id]);

        return response()->json(['success' => 'Author Deleted Successfully']);
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
}
