<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function authorImageUrl()
    {
        /*if(!is_null($this->profile_photo)){
            return url('/storage/photo/'. $this->photo);
        }*/
        return url('/themes/front/img/avatar-1.jpg');
    }
}
