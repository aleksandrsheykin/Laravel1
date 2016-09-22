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

Route::get('/home', 'HomeController@index')->name('home');

//admins route
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/admin/categories', 'AdminCategoriesController@index')->name('adminCategories')->middleware('admin');
Route::put('/admin/categories', 'AdminCategoriesController@put')->name('adminCategoriesPut')->middleware('admin');
Route::get('/admin/users', 'AdminUsersController@index')->name('adminUsers')->middleware('admin');
//Route::post('/admin/users', 'AdminUsersController@index')->name('adminUsers')->middleware('admin');
