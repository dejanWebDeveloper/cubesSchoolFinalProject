<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class PhotoService
{
    public function save($photo, $model, $field, $path = 'photo/author/')
    {
        $photoName = $model->id . '_' . $field . '_' . Str::uuid() . '.jpg';
        $relativePath = $path . $photoName;

        if (!empty($model->$field)) {
            $this->delete($model, $field, $path);
        }

        $image = Image::read($photo)
            ->cover(256, 256)
            ->toJpeg(90);

        Storage::disk('public')->put($relativePath, (string)$image);

        $model->$field = $photoName;
        $model->save();
    }

    public function delete($model, $field, $path = 'photo/author/')
    {
        if (empty($model->$field)) return;

        $filePath = $path . $model->$field;
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $model->$field = null;
        $model->save();
    }
    public function saveSliderPhoto($photo, $slider, $field)
    {
        // Generate unique filename
        $photoName = $slider->id . '_' . $field . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

        // Delete old photo if exists
        if ($slider->$field) {
            $oldPath = 'photo/slider/' . $slider->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        // Save new photo to storage
        $path = $photo->storeAs('photo/slider/', $photoName, 'public');

        // Update DB
        $slider->$field = basename($path);
        $slider->save();
    }
    public function deleteSliderPhoto($slider, $field)
    {
        if (!$slider->$field) return false;

        $path = 'photo/slider/' . $slider->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $slider->$field = null;
        $slider->save();

        return true;
    }
}
