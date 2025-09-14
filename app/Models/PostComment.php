<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
protected $fillable = [
    'name',
    'post_id',
    'email',
    'comment',
    'enable',
    'created_at'
];
public function post()
{
    return $this->belongsTo(Post::class, 'post_id', 'id');
}
}

