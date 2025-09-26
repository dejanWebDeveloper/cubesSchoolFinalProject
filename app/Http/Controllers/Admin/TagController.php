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
            'name' => ['required', 'string', 'between:5,30', 'unique:tags,name']
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

        // Detach all related posts first
        $tag->posts()->detach();
        $tag->delete();

        return response()->json(['success' => 'Tag Deleted Successfully']);
    }
}
