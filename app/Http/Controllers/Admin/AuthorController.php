<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

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
    public function datatable(Request $request)
    {
        $query = Author::query();

        if ($request->name) {
            $query->where('name', 'like', "%{$request->name}%");
        }
        if ($request->email) {
            $query->where('email', 'like', "%{$request->email}%");
        }
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
        $data['slug'] = Str::slug($data['name']);
        $data['created_at'] = now();
        $newAuthor = new Author();
        $newAuthor->fill($data)->save();
        //saving photo
        if (request()->hasFile('first-photo')) { //if has file
            $photo = request()->file('first-photo'); //save file to $photo
            //helper methode
            $this->savePhoto($photo, $newAuthor, 'profile_photo');
        }
        session()->put('system_message', 'Author Added Successfully');
        return redirect()->route('admin_authors_page');
    }

    public function savePhoto($photo, $author, $field)
    {
        // Generate unique filename
        $photoName = $author->id . '_' . $field . '_' . Str::uuid();
        $relativePath = 'photo/author/' . $photoName;

        // Delete old photo if exists
        if (!empty($author->$field)) {
            $oldPath = 'photo/author/' . $author->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Read + crop + resize + encode
        $image = Image::read($photo)
            ->cover(256, 256)
            ->toJpeg(90);

        // Save new photo to storage
        Storage::disk('public')->put($relativePath, (string) $image);

        // Update DB (store only filename if you prefer)
        $author->$field = $photoName;
        $author->save();
    }

    public function deletePhoto($author, $field)
    {
        if (!$author->$field) return false;

        $path = 'photo/author/' . $author->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $author->$field = null;
        $author->save();

        return true;
    }
    public function deleteAuthor()
    {
        $data = request()->validate([
            'author_for_delete_id' => ['required', 'numeric', 'exists:authors,id'],
        ]);
        $author = Author::findOrFail($data['author_for_delete_id']);
        $this->deletePhoto($author, 'profile_photo');
        $author->delete();

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
        $data = request()->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'email'],
            'first-photo' => ['file', 'mimes:jpeg,png,jpg', 'max:1000']
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['updated_at'] = now();

        $authorForEdit->fill($data)->save();
        //saving photo and delete old photo
        if ($request->hasFile('first-photo')) {
            $this->deletePhoto($authorForEdit, 'profile_photo');
            $this->savePhoto($request->file('first-photo'), $authorForEdit, 'profile_photo');
        }
        if ($request->has('delete_photo1') && $request->delete_photo1) {
            $this->deletePhoto($authorForEdit, 'profile_photo');
        }
        session()->put('system_message', 'Authors data Edited Successfully');
        return redirect()->route('admin_authors_page');
    }
}
