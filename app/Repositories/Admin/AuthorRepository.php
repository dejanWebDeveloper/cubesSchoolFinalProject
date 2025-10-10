<?php

namespace App\Repositories\Admin;


use App\Models\Author;
use Illuminate\Support\Str;
use App\Services\PhotoService;

class AuthorRepository
{
    protected $photoService;
    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }
    public function getFilteredAuthors(array $filters = [])
    {
        $query = Author::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', "%{$filters['email']}%");
        }

        return $query;
    }
    public function createAuthor($data)
    {
        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Author::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['created_at'] = now();
        $author = new Author();
        $author->fill($data)->save();
        return $author;
    }
    public function editAuthor($authorForEdit, $data)
    {
        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Author::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['updated_at'] = now();
        $authorForEdit->fill($data)->save();
        return $authorForEdit;
    }
    public function deleteAuthor($data)
    {
        $author = Author::findOrFail($data['author_for_delete_id']);
        $this->photoService->delete($author, 'profile_photo');
        $author->delete();
    }
}
