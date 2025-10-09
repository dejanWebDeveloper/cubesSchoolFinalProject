<?php

namespace App\Repositories\Front;

use App\Models\SliderData;
use Illuminate\Support\Facades\Cache;

class SliderDataRepository
{
    public function getSliderData()
    {
        $cacheKeySlider = "sliderData";
        return Cache::remember($cacheKeySlider, 1200, function () {
            return SliderData::where('status', 1)->orderBy('position', 'asc')->get();
        });
    }

}
