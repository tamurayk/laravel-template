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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tasks', 'Task\TaskIndexController')
    ->name('task.index')
    ->middleware('auth');

Route::post('/task', 'Task\TaskStoreController')
    ->name('task.store')
    ->middleware('auth');

Route::delete('/task/{task}', 'Task\TaskDestroyController')
    ->name('task.destroy')
    ->middleware('auth');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('oauth.login');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('oauth.callback');
