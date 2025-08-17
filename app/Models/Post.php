<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }
    public function imageUrl()
    {
        /*if(!is_null($this->photo)){
            return url('/storage/photo/'. $this->photo);
        }*/
        return url('/themes/front/img/gallery-1.jpg');
    }
}
