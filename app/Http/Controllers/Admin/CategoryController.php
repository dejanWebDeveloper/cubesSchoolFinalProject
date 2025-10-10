<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Admin\CategoryRepository;

class CategoryController extends Controller
{
    protected $categories;
    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }
    public  function  index()
    {
        return view('admin.category_pages.categories_page');
    }

    public  function  addCategory()
    {
        return view('admin.category_pages.add_category_form');
    }
    public function datatable()
    {
        $query = $this->categories->getFilteredCategory();

        return DataTables::of($query)
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('description', fn($row) => $row->description)
            ->addColumn('priority', fn($row) => $row->priority)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s'))
            ->addColumn('actions', fn($row) => view('admin.category_pages.partials.actions', compact('row')))
            ->rawColumns(['actions'])
            ->toJson();
    }
    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'between:5,50', 'unique:categories,name'],
            'description' => ['required', 'string', 'between:15,100'],
            'priority' => ['nullable', 'integer', 'between:1,10']
        ]);
        $this->categories->store($data);
        session()->put('system_message', 'Category Added Successfully');
        return redirect()->route('admin_categories_page');
    }
    public function deleteCategory()
    {
        $data = request()->validate([
            'category_for_delete_id' => ['required', 'integer', 'exists:categories,id']
        ]);
        $this->categories->delete($data);

        return response()->json(['success' => 'Category Deleted Successfully']);
    }
    public function editCategory($id, $slug)
    {
        $categoryForEdit = $this->categories->editPage($id, $slug);
        return view('admin.category_pages.edit_category_page', compact(
            'categoryForEdit'
        ));
    }
    public function storeEditedCategory(Category $categoryForEdit)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'between:5,50'],
            'description' => ['required', 'string', 'between:15,100'],
            'priority' => ['nullable', 'integer', 'between:1,10']
        ]);
        $this->categories->edit($data, $categoryForEdit);

        session()->put('system_message', 'Category Edited Successfully');
        return redirect()->route('admin_categories_page');
    }
}
