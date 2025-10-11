<?php

namespace App\Repositories\Admin;


use App\Models\Tag;
use Illuminate\Support\Str;

class TagRepository
{
    public function dataTableTags()
    {
        return Tag::query();
    }
    public function saveTag($data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['created_at'] = now();
        $tag = new Tag();
        $tag->fill($data)->save();
    }
    public function deleteOneTag($data)
    {
        $tag = Tag::findOrFail($data['tag_for_delete_id']);

        // Detach all related posts first
        $tag->posts()->detach();
        $tag->delete();
    }
}
