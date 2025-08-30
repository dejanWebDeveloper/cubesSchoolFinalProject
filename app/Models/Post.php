<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'heading',
        'slug',
        'preheading',
        'text',
        'photo',
        'additional_photo',
        'category_id',
        'author_id',
        'views',
        'enable',
        'important'
    ];
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
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }
    public function imageUrl()
    {
        if (!is_null($this->photo)) {
            return asset('storage/photo/' . $this->photo);
        }

        // Default photo
        return asset('themes/front/img/featured-pic-1.jpeg');
    }
    public function additionalImageUrl()
    {
        if (!is_null($this->additional_photo)) {
            return asset('storage/photo/' . $this->additional_photo);
        }
        return asset('themes/front/img/featured-pic-2.jpeg');
    }
    public function scopeStandardRequest($query)
    {
        return $query->with('category', 'author', 'tags')
            ->where('enable', 1)
            ->orderBy('created_at', 'desc');
    }
}
