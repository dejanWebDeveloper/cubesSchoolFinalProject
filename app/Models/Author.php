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
}
