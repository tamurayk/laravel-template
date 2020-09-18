<?php

use Illuminate\Support\Facades\Route;

/**
 * admin
 */
Route::namespace('Admin')->prefix('admin')->group(function () {
    // 認証済みの場合は、 guest middleware によって、RouteServiceProvider::ADMIN_HOME にリダイレクト
    // guest middleware = RedirectIfAuthenticated\App\Http\Middleware\RedirectIfAuthenticated (\App\Http\Kernel::$routeMiddleware にて設定)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/', function () {
            return view('admin.welcome');
        });

        Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
        Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    });

    /**
     * Require admin auth
     */
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

        Route::get('/home', 'Home\HomeIndexController')->name('admin.home.index');

        Route::get('/users', 'User\UserIndexController')->name('admin.user.index');
    });
});
