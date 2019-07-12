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

//products
Route::get('/products',
    [   'as' => 'products',
        'uses' => 'Products@index']);
Route::get('/addProduct','Products@addProduct');
Route::post('/create','Products@create');
Route::get('/delete/{id}','Products@delete');
Route::get('/edit/{id}','Products@edit');
Route::post('/update','Products@update');
Route::post('/select_subcate','Products@selectSub');
Route::get('/activate/{id}','Products@activate');

//todo list
Route::get('/todolist','ToDoController@index');
Route::post('/create_todo','ToDoController@createtodo');
Route::get('/deletetodo/{id}','ToDoController@deletetodo');
Route::get('/pdf','ToDoController@generatePDF');
Route::get('/excel','ToDoController@generateExcel');

//cart products
Route::get('/display',
    [   'as' => 'display',
        'uses' => 'HomeController@DisplayProduct']);
Route::get('/cart','HomeController@cartView');
Route::get('/add_to_cart/{id}','HomeController@addToCart');
Route::get('/delete_cart/{id}','HomeController@deleteCart');
Route::post('/update_cart','HomeController@updateCart');

//checkout
Route::get('/checkout','HomeController@checkout');
Route::get('/order','HomeController@order');

Route::get('/myorders','HomeController@myorders');

//category
Route::get('/category',
    [   'as' => 'category',
        'uses' => 'Category@index']);
Route::get('/addCategory','Category@addCategory');
Route::post('/create_category','Category@storeCategory');
Route::get('/edit_category/{id}','Category@edit');
Route::post('/update_category','Category@update');
Route::get('/delete_category/{id}','Category@delete');
Route::get('/activate_category/{id}','Category@activate');



//Sub category
Route::get('/subcategory',
    [   'as' => 'subcategory',
        'uses' => 'SubCategory@index']);
Route::get('/addSubCategory','SubCategory@add');
Route::post('/create_subcategory','SubCategory@store');
Route::get('/edit_subcategory/{id}','SubCategory@edit');
Route::post('/update_subcategory','SubCategory@update');
Route::get('/delete_subcategory/{id}','SubCategory@delete');
Route::get('/activate_subcategory/{id}','SubCategory@activate');

//Multiple Image Upload
Route::get('/Prodimages','Products@images');
Route::get('/addImage','Products@addImage');
Route::post('/createImage','Products@createImage');
