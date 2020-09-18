<?php

use Illuminate\Support\Facades\Route;

/**
 * admin
 */
Route::namespace('Admin')->prefix('admin')->group(function () {
    /**
     * 認証済みの場合は、 guest middleware によって、RouteServiceProvider::ADMIN_HOME にリダイレクト
     *   guest middleware = RedirectIfAuthenticated\App\Http\Middleware\RedirectIfAuthenticated (\App\Http\Kernel::$routeMiddleware にて設定)
     */
    Route::middleware('guest:admin')->group(function () {
        Route::get('/', 'IndexController')->name('admin.index');

        Route::namespace('Auth')->group(function () {
            Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
            Route::post('login', 'LoginController@login')->name('admin.login');
        });
    });

    /**
     * Require admin auth
     */
    Route::middleware('auth:admin')->group(function () {
        Route::namespace('Auth')->group(function () {
            Route::post('logout', 'LoginController@logout')->name('admin.logout');
        });

        Route::namespace('Home')->group(function () {
            Route::get('/home', 'HomeIndexController')->name('admin.home.index');
        });

        Route::namespace('User')->group(function () {
            Route::get('/users', 'UserIndexController')->name('admin.user.index');
        });
    });
});
