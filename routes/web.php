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
Route::get('/authors', 'AjaxController@authors');
Route::get('/books', 'AjaxController@books');
Route::get('/task', 'AjaxController@task');
Route::get('/file', 'AjaxController@file');
Route::get('/save', function (){
    return view('save');
});