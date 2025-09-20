<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'profile_photo'
    ];
    public function authorImageUrl()
    {
        if (!is_null($this->profile_photo)) {
            return asset('storage/photo/author/' . $this->profile_photo);
        }

        // Default photo
        return asset('themes/front/img/avatar-1.jpg');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($author) {
            // delete all posts of author
            $author->posts()->delete();
        });
    }

}
