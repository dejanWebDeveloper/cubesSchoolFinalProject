<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderData extends Model
{
    public function sliderImageUrl()
    {
        /*if(!is_null($this->background)){
            return url('/storage/photo/'. $this->photo);
        }*/
        return url('/themes/front/img/featured-pic-2.jpeg');
    }
}
