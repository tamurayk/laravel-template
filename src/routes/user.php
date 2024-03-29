<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Controllers\User\IndexController::class)->name('index');

// MEMO: Laravel標準の src/app/Http/Controllers/Auth ではなく src/app/Http/Controllers/User/Auth 以下にユーザー向けの Auth 関連のコントローラーがある為、namespace を補完する必要がある
Route::namespace('App\Http\Controllers\User')->group(function () {
    Auth::routes([
        'register' => true,
        'reset' => false,
        'confirm' => false,
        'verify' => false,
    ]);

});

/**
 * If authenticated, redirect to RouteServiceProvider::HOME by guest middleware.
 * note: guest middleware = RedirectIfAuthenticated\App\Http\Middleware\RedirectIfAuthenticated (See: \App\Http\Kernel::$routeMiddleware)
 */
Route::middleware('guest:user')->group(function () {
    /**
     * OAuth Login
     */
    Route::get('login/{provider}', \App\Http\Controllers\User\Auth\LoginController::class . '@redirectToProvider')->name('oauth.login');
    Route::get('login/{provider}/callback', \App\Http\Controllers\User\Auth\LoginController::class . '@handleProviderCallback')->name('oauth.callback');
});

/**
 * Require user auth
 */
Route::middleware('auth:user')->group(function () {

    Route::get('home', \App\Http\Controllers\User\Home\HomeIndexController::class)->name('home.index');

    Route::get('tasks', \App\Http\Controllers\User\Task\TaskIndexController::class)->name('task.index');
    Route::post('task', \App\Http\Controllers\User\Task\TaskStoreController::class)->name('task.store');
    Route::delete('task/{task}', \App\Http\Controllers\User\Task\TaskDestroyController::class)->name('task.destroy');
});
