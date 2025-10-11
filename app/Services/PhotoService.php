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
    public function savePostPhoto($photo, $post, $field)
    {
        // Generate unique filenames
        $baseName = $post->id . '_' . $field . '_' . Str::uuid();
        $extension = $photo->getClientOriginalExtension();

        $photoName = $baseName . '.' . $extension;
        $photoThumbName = $baseName . '_thumb.' . $extension;

        // Delete old photo + thumb if they exist
        if ($post->$field) {
            $oldPath = 'photo/' . $post->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        if ($post->additional_photo) {
            $oldThumbPath = 'photo/' . $post->additional_photo;
            if (Storage::disk('public')->exists($oldThumbPath)) {
                Storage::disk('public')->delete($oldThumbPath);
            }
        }

        // Save normal photo
        $photo->storeAs('photo', $photoName, 'public');

        // Create + save thumbnail
        $thumbPath = 'photo/' . $photoThumbName;
        $image = Image::read($photo)
            ->cover(256, 256)   // crop + resize
            ->toJpeg(90);       // compress
        Storage::disk('public')->put($thumbPath, (string)$image);

        // Update DB with relative paths
        $post->$field = $photoName;
        $post->additional_photo = $photoThumbName;
        $post->save();
    }

    public function deletePostPhoto($post, $field)
    {
        if (!$post->$field) {
            return false;
        }

        // Delete main photo
        $path = 'photo/' . $post->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Delete thumbnail if exists
        if ($post->additional_photo) {
            $thumbPath = 'photo/' . $post->additional_photo;
            if (Storage::disk('public')->exists($thumbPath)) {
                Storage::disk('public')->delete($thumbPath);
            }
        }

        // Clear DB fields
        $post->$field = null;
        $post->additional_photo = null;
        $post->save();

        return true;
    }
    public function saveUserPhoto($photo, $user, $field)
    {
        // Generate unique filename
        $photoName = $user->id . '_' . $field . '_' . Str::uuid();
        $relativePath = 'photo/user/' . $photoName;
        // Delete old photo if exists
        if (!empty($user->$field)) {
            $oldPath = 'photo/user/' . $user->$field;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        // Read + crop + resize + encode
        $image = Image::read($photo)
            ->cover(256, 256)
            ->toJpeg(90);
        // Save new photo to storage
        Storage::disk('public')->put($relativePath, (string) $image);
        // Update DB (store only filename if you prefer)
        $user->$field = $photoName;
        $user->save();
    }

    public function deleteUserPhoto($user, $field)
    {
        if (!$user->$field) return false;
        $path = 'photo/user/' . $user->$field;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
        $user->$field = null;
        $user->save();
        return true;
    }
}
