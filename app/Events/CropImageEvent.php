<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CropImageEvent
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
        $this->path = $path;
    }
}
