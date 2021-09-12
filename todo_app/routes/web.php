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

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource("goals", "GoalController");

Route::resource("goals.todos", "TodoController");

Route::post('/goals/{goal}/todos/{todo}/sort', 'TodoController@sort');

Auth::routes(); //ログイン機能で必要なルーティング
