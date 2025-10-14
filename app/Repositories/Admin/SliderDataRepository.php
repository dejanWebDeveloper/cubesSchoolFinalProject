<?php
namespace App\Repositories\Admin;

use App\Models\SliderData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\PhotoService;

class SliderDataRepository
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function getFilteredSliderData()
    {
        $query = SliderData::select(['id', 'heading', 'slug', 'background', 'url', 'button_name', 'status', 'position', 'created_at'])
            ->orderBy('position', 'asc');
        return $query;
    }

    public function save($data)
    {
        $slug = Str::slug($data['heading']);
        $originalSlug = $slug;
        $counter = 1;
        while (SliderData::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        $data['position'] = 1;
        $data['status'] = 1;
        $data['created_at'] = now();
        $slider = new SliderData();
        $slider->fill($data)->save();
        return $slider;
    }

    public function delete($data)
    {
        $slider = SliderData::findOrFail($data['slider_for_delete_id']);
        $this->photoService->deleteSliderPhoto($slider, 'background');
        $slider->delete();
    }

    public function editSliderPage($id, $slug)
    {
        return SliderData::where('slug', $slug)->where('id', $id)->firstOrFail();
    }

    public function editSlider($data, SliderData $sliderForEdit)
    {
        $slug = Str::slug($data['heading']);
        $originalSlug = $slug;
        $counter = 1;
        while (SliderData::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data['slug'] = $slug;
        if (!isset($data['status'])) {
            $data['status'] = 1; // ili 0 ako želiš da novi slider bude disabled po defaultu
        }
        if (($data['position'])) {
            $data['position'] = 1; // ili 0 ako želiš da novi slider bude disabled po defaultu
        }else{
            $data['position'] = $sliderForEdit->position;
        }

        $data['updated_at'] = now();
        $sliderForEdit->fill($data)->save();
        return $sliderForEdit;
    }

    public function disable($data)
    {
        $slider = SliderData::findOrFail($data['slider_for_disable_id']);
        $slider->status = 0;
        $slider->save();
    }

    public function enable($data)
    {
        $slider = SliderData::findOrFail($data['slider_for_enable_id']);
        $slider->status = 1;
        $slider->save();
    }

    public function sorting(Request $request)
    {
        foreach ($request->order as $item) {
            SliderData::where('id', $item['id'])
                ->update(['position' => $item['position']]);
        }
    }
}
