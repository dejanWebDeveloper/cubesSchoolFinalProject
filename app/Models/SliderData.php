<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderData extends Model
{
    protected $fillable = [
        'background',
        'heading',
        'slug',
        'button_name',
        'url',
        'status',
        'position'
    ];
    public function sliderImageUrl()
    {
        if(!is_null($this->background)){
            return asset('storage/photo/slider/' . $this->background);
        }
        return asset('/themes/front/img/featured-pic-2.jpeg');
    }
}
