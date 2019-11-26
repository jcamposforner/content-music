<?php

namespace App\Providers;

use App\Services\UploadService;
use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UploadService::class);
    }
}
