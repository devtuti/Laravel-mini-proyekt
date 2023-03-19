<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'UserController@users');
Route::post('/user-add', 'UserController@user_insert')->name('user.post');
Route::get('/user-search', 'UserController@user_search')->name('user_search.action');
Route::get('/user-del', 'UserController@user_del')->name('user.del');
Route::get('/user-show', 'UserController@user_show')->name('user.show');
Route::post('/user-update', 'UserController@user_update')->name('user.update');

