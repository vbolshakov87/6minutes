<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::pattern('id', '[0-9]+');



Route::get('/','HomeController@index');

Route::get('login', 'UserController@showLogin');
Route::post('login', 'UserController@doLogin');
Route::get('logout', array('uses' => 'UserController@doLogout'));

Route::get('moderate/all/', 'AdminController@moderateAll');
Route::get('moderate/{id}/', 'AdminController@moderate');
Route::get('domoderate/{action}/{id}/', 'AdminController@doModerate');
Route::get('create', 'HomeController@showCreate');
Route::post('create', 'HomeController@postCreate');
