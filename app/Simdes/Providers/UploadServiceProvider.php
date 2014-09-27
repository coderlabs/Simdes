<?php

namespace Simdes\Providers;

use Illuminate\Support\ServiceProvider;
use Simdes\Services\Upload\ImageUploadService;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['upload.image'] = $this->app->share(function ($app) {
            return new ImageUploadService($app['files']);
        });
    }
}
