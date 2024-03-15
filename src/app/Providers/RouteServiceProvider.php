<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string|null
     *
     * MEMO:
     *  Laravel 7 以前では、$namespace プロパティを RouteServiceProvider に設定することで、
     *  グルーバルに名前空間のプレフィックスをルート定義に自動的に適用することが可能だったが、
     *  Laravel 8 以降では、デフォルトでは無効なり、Route定義でコントローラーを参照する際に、完全修飾名を使用することが推奨されるようになった。
     *
     * Laravel 7
     *   in \App\Providers\RouteServiceProvider
     *     $namespace = 'App\Http\Controllers';
     *
     *   in \routes\user.php
     *     Route::get('/users', 'UserController@index');
     *
     *   のように、コントローラーを指定する際に、名前空間を省略して短縮形でしていしていた
     *
     * Laravel 8
     *   in \routes\user.php
     *     $namespace = null; //デフォルトではコメントアウト
     *
     *   in \routes\user.php
     *     use App\Http\Controllers\UserController;
     *     Route::get('/users', [UserController::class, 'index']);
     *
     *   のように、コントローラーを指定する際に、コントローラーの完全修飾名を指定する思想になった
     */
    protected $namespace = null;

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';
    public const ADMIN_HOME = '/admin/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('user')
             ->group(base_path('routes/user.php'));
    }

    /**
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
