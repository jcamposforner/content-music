<?php

namespace App\Listeners;

use App\Constants\StorageConstants;
use FFMpeg\Coordinate\FrameRate;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\Dimension;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\Facades\Image;

class ResizeVideoListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach (StorageConstants::RESIZED_VIDEOS_VALUES as $resolution) {
            $ffmpeg = FFMpeg::create([
                'ffmpeg.binaries'  => env('FFMPEG_BIN'),
                'ffprobe.binaries' => env('FFPROBE_BIN'),
                'ffmpeg.threads'   => env('FFMPEG_THREADS'),
                'ffmpeg.timeout'   => env('FFMPEG_TIMEOUT'),
                'ffprobe.timeout'   => env('FFPROBE_TIMEOUT')
            ]);
            $fileName = "{$resolution[0]}_{$resolution[1]}_".basename($event->path);
            $video = $ffmpeg->open($event->path);
            $video
                ->filters()
                ->framerate(new FrameRate(30), 1)
                ->resize(new Dimension($resolution[0], $resolution[1]))
                ->synchronize();
            $video->save(new X264('aac'), storage_path(StorageConstants::RESIZED_VIDEOS).$fileName);
        }
    }
}
