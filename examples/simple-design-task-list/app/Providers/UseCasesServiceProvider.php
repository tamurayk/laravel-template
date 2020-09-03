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
            \App\Http\UseCases\Task\Contracts\TaskIndexUseCaseInterface::class,
            \App\Http\UseCases\Task\TaskIndexUseCase::class
        );
        $this->app->bind(
            \App\Http\UseCases\Task\Contracts\TaskStoreUseCaseInterface::class,
            \App\Http\UseCases\Task\TaskStoreUseCase::class
        );
        $this->app->bind(
            \App\Http\UseCases\Task\Contracts\TaskDestroyUseCaseInterface::class,
            \App\Http\UseCases\Task\TaskDestroyUseCase::class
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
