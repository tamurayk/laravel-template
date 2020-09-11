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

Route::get('/', function () {
    return view('welcome');
});

// TODO: 不要になったら削除する
Auth::routes();

// GET /
Route::get('/home', 'HomeController@index')->name('home');

// GET /tasks
Route::get('/tasks', 'Task\TaskIndexController')
    ->name('task.index')
    ->middleware('auth');

// POST /task
Route::post('/task', 'Task\TaskStoreController')
    ->name('task.store')
    ->middleware('auth');

// DELETE /task/{task}
Route::delete('/task/{task}', 'Task\TaskDestroyController')
    ->name('task.destroy')
    ->middleware('auth');

/**
 * OAuth Login
 */
// GET /login/{provider}
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('oauth.login');
// GET /login/{provider}/callback
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('oauth.callback');

/**
 * admin
 */
Route::prefix('admin')->group(function () {
    // TODO: add auth middleware
    // GET /admin/users
    Route::get('users', 'Admin\User\UserIndexController')
        ->name('admin.user.index');
});
