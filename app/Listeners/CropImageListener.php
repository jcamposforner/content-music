<?php

namespace App\Listeners;

use App\Constants\StorageConstants;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\Facades\Image;

class CropImageListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach (StorageConstants::RESIZED_IMAGES_VALUES as $dimensions) {
            $img = Image::make($event->path)->resize($dimensions[0], $dimensions[1]);

            $fileName = "{$img->filename}_{$dimensions[0]}_{$dimensions[1]}.$img->extension";

            $img->save(storage_path(StorageConstants::IMAGES_THUMBNAIL.$fileName));
        }
    }
}
