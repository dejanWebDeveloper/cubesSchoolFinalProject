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
}
