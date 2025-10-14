<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\TagRepository;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    protected $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tag_pages.tags_page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag_pages.add_tag_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'between:5,30', 'unique:tags,name']
        ]);
        $this->tags->saveTag($data);

        session()->put('system_message', 'Tag Added Successfully');
        return redirect()->route('admin.tags.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = request()->validate([
            'tag_for_delete_id' => ['required', 'integer', 'exists:tags,id']
        ]);
        $this->tags->deleteOneTag($data);
        return response()->json(['success' => 'Tag Deleted Successfully']);
    }

    public function datatable()
    {
        $query = $this->tags->dataTableTags();

        return DataTables::of($query)
            ->addColumn('name', fn($row) => $row->name)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s'))
            ->addColumn('actions', fn($row) => view('admin.tag_pages.partials.actions', compact('row')))
            ->rawColumns(['actions'])
            ->toJson();
    }
}
