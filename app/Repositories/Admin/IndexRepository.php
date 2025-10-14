<?php

namespace App\Repositories\Admin;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Author;
use App\Models\PostComment;

class IndexRepository
{
    public function getDashboardStats(): array
    {
        return [
            'numberOfPosts' => Post::count(),
            'numberOfCategories' => Category::count(),
            'numberOfTags' => Tag::count(),
            'numberOfUsers' => User::count(),
            'numberOfAuthors' => Author::count(),
            'numberOfComments' => PostComment::count(),
        ];
    }
}
