<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryRepository
{
    public function getFilteredCategory()
    {
        $query = Category::query();

        $name = request()->name;
        $description = request()->description;
        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }
        if ($description) {
            $query->where('description', 'like', "%{$description}%");
        }
        return $query;
    }
    public function store($data)
    {
        $data['slug'] = Str::slug($data['name']);
        $lastCategory = Category::orderByDesc('priority')->first();
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
            }
        }
        $data['created_at'] = now();
        $newCategory = new Category();
        $newCategory->fill($data)->save();
    }
    public function delete($data)
    {
        $category = Category::findOrFail($data['category_for_delete_id']);
        $category->delete();
        $incrementCategories = Category::where('priority', '>', $category->priority)
            ->orderByDesc('priority')
            ->get();
        foreach ($incrementCategories as $incrementCategory) {
            $incrementCategory->priority -= 1;
            $incrementCategory->save();
        }
    }
    public function edit($data, Category $categoryForEdit)
    {
        $data['slug'] = Str::slug($data['name']);
        $lastCategory = Category::orderByDesc('priority')->firstOrFail();
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
    }
}
