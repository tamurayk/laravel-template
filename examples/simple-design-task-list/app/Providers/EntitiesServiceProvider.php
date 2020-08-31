<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class EntitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Entities\Contracts\Task::class,
            \App\Entities\Eloquents\Task::class
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