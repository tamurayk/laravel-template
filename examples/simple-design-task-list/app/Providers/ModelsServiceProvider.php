<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class ModelsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Models\Entities\UserInterface::class,
            \App\Models\Eloquents\User::class
        );

        $this->app->bind(
            \App\Models\Entities\TaskInterface::class,
            \App\Models\Eloquents\Task::class
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