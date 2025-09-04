<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function index()
    {
        return view('admin.tag_pages.tags_page');
    }
    public function addTag()
    {
        return view('admin.tag_pages.add_tag_form');
    }
    public function datatable(Request $request)
    {
        $query = Tag::query();

        return DataTables::of($query)
            ->addColumn('name', fn($row) => $row->name)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s'))
            ->addColumn('actions', fn($row) => view('admin.tag_pages.partials.actions', compact('row')))
            ->rawColumns(['actions'])
            ->toJson();
    }
    public function storeTag()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'between:5,30']
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['created_at'] = now();
        $newTag = new Tag();
        $newTag->fill($data)->save();

        session()->put('system_message', 'Tag Added Successfully');
        return redirect()->route('admin_tags_page');
    }
    public function deleteTag()
    {
        $data = request()->validate([
            'tag_for_delete_id' => ['required', 'integer', 'exists:tags,id']
        ]);
        $tag = Tag::findOrFail($data['tag_for_delete_id']);
        $tag->delete();
        return response()->json(['success' => 'Tag Deleted Successfully']);
    }
    public function editTag($slug)
    {
        $tagForEdit = Tag::where('slug', $slug)->firstOrFail();
        return view('admin.tag_pages.edit_tag_page', compact(
            'tagForEdit'
        ));
    }
    public function storeEditedTag(Tag $tagForEdit)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'between:5,30']
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['updated_at'] = now();
        $tagForEdit->fill($data)->save();
        session()->put('system_message', 'Tag Edited Successfully');
        return redirect()->route('admin_tags_page');
    }
}
