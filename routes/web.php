<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'IndexController@index')->name('index');
Route::get('/settings', 'SettingsController@index')->name('settings');

Auth::routes();

//HomeController have middleware('auth')
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{date_mainform}', 'HomeController@index')->where('date_mainform', '(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d');	//пропускаем только даты

Route::get('/categories', 'HomeController@index')->name('categories');
Route::get('/accounts', 'HomeController@index')->name('accounts');
Route::get('/cheaper', 'HomeController@index')->name('cheaper');
Route::get('/question', 'HomeController@index')->name('question');


//admins route
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');

Route::get('/admin/categories', 'AdminCategoriesController@index')->name('adminCategories')->middleware('admin');
Route::put('/admin/categories', 'AdminCategoriesController@put')->name('adminCategoriesPut')->middleware('admin');
Route::delete('/admin/categories', 'AdminCategoriesController@del')->name('adminCategoriesDel')->middleware('admin');
Route::options('/admin/categories', 'AdminCategoriesController@edit')->name('adminCategoriesEdit')->middleware('admin');

Route::get('/admin/users', 'AdminUsersController@index')->name('adminUsers')->middleware('admin');
