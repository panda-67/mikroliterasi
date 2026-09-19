<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    public function attach(
        Model $model,
        UploadedFile $file,
        ?string $caption = null
    ): Media {
        $path = $file->store(
            'media',
            'public'
        );

        return $model->media()->create([
            'file' => $path,
            'caption' => $caption,
        ]);
    }

    public function update(
        Media $media,
        array $data
    ): Media {
        $media->update($data);

        return $media->refresh();
    }

    public function delete(Media $media): bool
    {
        $path = $media->file;

        $deleted = $media->delete();

        if ($deleted && $path) {
            Storage::disk('public')->delete($path);
        }

        return $deleted;
    }
}
