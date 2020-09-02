<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RequestsServiceProvider
 * @package App\Providers
 */
final class RequestsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Http\Requests\Task\Contracts\TaskStoreRequestInterface::class,
            \App\Http\Requests\Task\TaskStoreRequest::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}