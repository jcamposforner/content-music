<?php

namespace App\Events;

use FFMpeg\FFMpeg;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResizeVideoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $path;

    /**
     * CropImageEvent constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path   = $path;
    }
}
