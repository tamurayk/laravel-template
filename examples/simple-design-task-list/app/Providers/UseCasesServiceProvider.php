<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

final class UseCasesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Http\UseCases\Task\Interfaces\TaskIndexInterface::class,
            \App\Http\UseCases\Task\TaskIndex::class
        );
        $this->app->bind(
            \App\Http\UseCases\Task\Interfaces\TaskStoreInterface::class,
            \App\Http\UseCases\Task\TaskStore::class
        );
        $this->app->bind(
            \App\Http\UseCases\Task\Interfaces\TaskDestroyInterface::class,
            \App\Http\UseCases\Task\TaskDestroy::class
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
