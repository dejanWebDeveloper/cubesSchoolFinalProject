<?php

namespace App\Repositories\Admin;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\PhotoService;

class PostRepository
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }
    public function postContent()
    {
        return [
            'categories' => Category::all(),
            'authors' => Author::all(),
            'tags' => Tag::all()
            ];
    }

    public function dataTable(Request $request)
    {
        $query = Post::withCount('comments')->with(['category', 'author']);

        if ($request->heading) {
            $query->where('heading', 'like', "%{$request->heading}%");
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->author_id) {
            $query->where('author_id', $request->author_id);
        }
        if ($request->enable !== null && $request->enable !== '') {
            $query->where('enable', $request->enable);
        }
        if ($request->important !== null && $request->important !== '') {
            $query->where('important', $request->important);
        }
        if ($request->filled('tags_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags_id);
            });
        }
        return $query;
    }

    public function savePost($data)
    {
        $slug = Str::slug($data['heading']);
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['enable'] = 1;
        $data['important'] = 0;
        $data['created_at'] = now();
        $data['text'] = strip_tags($data['text'], '<img>');
        $post = new Post();
        $post->fill($data)->save();
        //table tags
        $post->tags()->sync($data['tags']);
        return $post;

    }
    public function deletePost($data)
    {
        $post = Post::findOrFail($data['post_for_delete_id']);
        // Delete associated photos before removing DB record
        $this->photoService->deletePostPhoto($post, 'photo');
        // Detach tags
        $post->tags()->sync([]);
        // Finally delete the post
        $post->delete();
    }
    public function editPost($id, $slug)
    {
        return Post::where('slug', $slug)->where('id', $id)->firstOrFail();
    }

    public function saveEditedPost($data, Post $postForEdit)
    {
        $slug = Str::slug($data['heading']);
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['enable'] = 1;
        $data['important'] = 0;
        $data['created_at'] = now();
        $data['text'] = strip_tags($data['text'], '<img>');
        $postForEdit->fill($data)->save();
        //table tags
        $postForEdit->tags()->sync($data['tags']);
        return $postForEdit;
    }
    public function deletePhotoJS($postForEdit)
    {
        if ($postForEdit->photo) {
            Storage::disk('public')->delete('photo/' . $postForEdit->photo);
            $postForEdit->photo = null;
            $postForEdit->save();
        }
    }
    public function disableOnePost($data)
    {
        $post = Post::findOrFail($data['post_for_disable_id']);
        $post->enable = 0;
        $post->save();
    }
    public function enableOnePost($data)
    {
        $post = Post::findOrFail($data['post_for_enable_id']);
        $post->enable = 1;
        $post->save();
    }
    public function unimportant($data)
    {
        $post = Post::findOrFail($data['post_be_unimportant_id']);
        $post->important = 0;
        $post->save();
    }
    public function important($data)
    {
        $post = Post::findOrFail($data['post_be_important_id']);
        $post->important = 1;
        $post->save();
    }
    public function dataTableComments($request)
    {
        $query = PostComment::query();

        if ($request->post_id) {
            $query->where('post_id', $request->post_id);
        }
        return $query;
    }
    public function disableOneComment($data)
    {
        $postComment = PostComment::findOrFail($data['comment_for_disable_id']);
        $postComment->enable = 0;
        $postComment->save();
    }
    public function enableOneComment($data)
    {
        $postComment = PostComment::findOrFail($data['comment_for_enable_id']);
        $postComment->enable = 1;
        $postComment->save();
    }
}
