<?php

namespace App\Providers;

use App\Events\CropImageEvent;
use App\Events\NewUserHasRegisteredEvent;
use App\Listeners\CropImageListener;
use App\Listeners\RegisterMailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewUserHasRegisteredEvent::class => [
            RegisterMailListener::class,
        ],
        CropImageEvent::class => [
            CropImageListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
