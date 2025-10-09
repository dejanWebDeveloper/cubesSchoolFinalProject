<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

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
    protected static function booted()
    {
        static::created(function ($post) {
            self::clearBlogCache();
        });

        static::updated(function ($post) {
            self::clearBlogCache();
        });

        static::deleted(function ($post) {
            self::clearBlogCache();
        });
    }

    /**
     * input cache key to index file
     */
    public static function addCacheKeyToIndex(string $key)
    {
        $indexFile = storage_path('framework/cache/index.json');

        $index = [];
        if (File::exists($indexFile)) {
            $index = json_decode(File::get($indexFile), true) ?: [];
        }

        if (!in_array($key, $index)) {
            $index[] = $key;
            File::put($indexFile, json_encode($index));
        }
    }

    /**
     * delete all files which exist in index
     */
    public static function clearBlogCache()
    {
        $indexFile = storage_path('framework/cache/index.json');

        if (!File::exists($indexFile)) {
            return;
        }

        $index = json_decode(File::get($indexFile), true) ?: [];

        foreach ($index as $key) {
            Cache::forget($key);
        }

        // Reset index
        File::put($indexFile, json_encode([]));
    }
}
