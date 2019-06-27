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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/addProduct','HomeController@addProduct');
Route::post('/create','HomeController@create');
Route::get('/delete/{id}','HomeController@delete');
Route::get('/edit/{id}','HomeController@edit');
Route::post('/update','HomeController@update');
