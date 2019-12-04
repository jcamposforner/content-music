<?php

namespace App\Providers;

use App\Repositories\ContentRepository;
use App\Repositories\ContentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ContentRepositoryInterface::class,
            ContentRepository::class
        );
    }
}
