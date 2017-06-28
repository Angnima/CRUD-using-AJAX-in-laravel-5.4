<?php

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

Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login/auth', 'AuthController@login')->name('login.auth');
Route::get('/logout', 'AuthController@logout')->name('logout.me');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/news', 'NewsController@index')->name('news');
Route::get('/news/show', 'NewsController@all')->name('news.all');
Route::post('/news/add', 'NewsController@add')->name('news.add');
Route::post('/news/delete/', 'NewsController@delete')->name('news.delete');
Route::post('/news/update/', 'NewsController@update')->name('news.update');
Route::post('/news/save/', 'NewsController@saveUpdate')->name('saveUpdate');