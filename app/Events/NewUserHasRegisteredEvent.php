<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUserHasRegisteredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User saved
     *
     * @var User
     */
    public $user;

    /**
     * UUID for verification email
     *
     * @var string
     */
    public $uuid;

    /**
     * NewUserHasRegisteredEvent constructor.
     * @param User $user
     * @param string $uuid
     */
    public function __construct(User $user, string $uuid)
    {
        $this->user = $user;
        $this->uuid = $uuid;
    }
}
