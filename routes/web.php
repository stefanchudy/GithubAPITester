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

Route::get('/followers/{username}', 'HomeController@followersPage');
Route::get('/getNameList/{keyword}', 'HomeController@getNameList');
Route::get('/getFollowersList/{username}', 'HomeController@getFollowersList');
