<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public  function  index()
    {
        return view('admin.category_pages.categories_page');
    }

    public  function  addCategory()
    {
        return view('admin.category_pages.add_category_form');
    }
    public function datatable(Request $request)
    {
        $query = Category::query();

        if ($request->name) {
            $query->where('name', 'like', "%{$request->name}%");
        }
        if ($request->description) {
            $query->where('description', 'like', "%{$request->description}%");
        }
        return DataTables::of($query)
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('description', fn($row) => $row->description)
            ->addColumn('priority', fn($row) => $row->priority)
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d/m/Y H:i:s'))
            ->addColumn('actions', fn($row) => view('admin.category_pages.partials.actions', compact('row')))
            ->rawColumns(['actions'])
            ->toJson();
    }
    public function storeCategory()
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'between:5,50'],
            'description' => ['required', 'string', 'between:15,100'],
            'priority' => ['nullable', 'integer', 'between:1,10']
        ]);
        $data['slug'] = Str::slug($data['name']);
        $lastCategory = Category::orderByDesc('priority')->FirstOrFail();
        if (!$data['priority']){
            $data['priority'] = $lastCategory->priority + 1;
        }else{
            $categories = Category::all();
            $categoryPriorities = $categories->pluck('priority')->toArray();
            $incrementCategories = Category::where('priority', '>=', $data['priority'])
                ->orderByDesc('priority')
                ->get();
            if (in_array($data['priority'], $categoryPriorities)){

                foreach ($incrementCategories as $incrementCategory){
                    $incrementCategory->priority += 1;
                    $incrementCategory->save();
                }

            }else{
                $data['priority'] = $lastCategory->priority + 1;
            }

        }
        $data['created_at'] = now();
        $newCategory = new Category();
        $newCategory->fill($data)->save();

        session()->put('system_message', 'Category Added Successfully');
        return redirect()->route('admin_categories_page');
    }
    public function deleteCategory()
    {
        $data = request()->validate([
            'category_for_delete_id' => ['required', 'integer', 'exists:categories,id']
        ]);
        $category = Category::findOrFail($data['category_for_delete_id']);
        $category->delete();
        $incrementCategories = Category::where('priority', '>', $category->priority)
            ->orderByDesc('priority') // DESC ključ: obrnutim redosledom izbegava conflict
            ->get();
        foreach ($incrementCategories as $incrementCategory) {
            $incrementCategory->priority -= 1;
            $incrementCategory->save();
        }
        return response()->json(['success' => 'Category Deleted Successfully']);
    }
    public function editCategory($slug)
    {
        $categoryForEdit = Category::where('slug', $slug)->firstOrFail();
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
        $data['slug'] = Str::slug($data['name']);
        $lastCategory = Category::orderByDesc('priority')->FirstOrFail();
        if (!$data['priority']){
            $data['priority'] = $lastCategory->priority + 1;
        }else {
            $categories = Category::all();
            $categoryPriorities = $categories->pluck('priority')->toArray();
            if (in_array($data['priority'], $categoryPriorities)) {
                $incrementCategories = Category::where('priority', '>=', $data['priority'])
                    ->orderByDesc('priority')
                    ->get();
                foreach ($incrementCategories as $incrementCategory) {
                    $incrementCategory->priority += 1;
                    $incrementCategory->save();
                }
            }
        }
        $data['updated_at'] = now();
        $categoryForEdit->fill($data)->save();
        session()->put('system_message', 'Category Edited Successfully');
        return redirect()->route('admin_categories_page');
    }
}
