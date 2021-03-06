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

Route::resource("goals", "GoalController")->middleware('auth');

Route::resource("goals.todos", "TodoController")->middleware('auth');

Route::post('/goals/{goal}/todos/{todo}/tags/{tag}', 'TodoController@addTag')->middleware('auth');

Route::delete('/goals/{goal}/todos/{todo}/tags/{tag}', 'TodoController@removeTag')->middleware('auth');

Route::post('/goals/{goal}/todos/{todo}/sort', 'TodoController@sort')->middleware('auth');

Route::resource("tags", "TagController")->middleware('auth');

Auth::routes(); //ログイン機能で必要なルーティング

/*HTML 内で リンク先 URL などでセキュリティが低い http を使用していると
「送信しようとしている情報は保護されません」と表示され処理が実行されなくなる。
以下のコードを入れることで、http を強制的にセキュリティの高い https に変換してくれる。*/
URL::forceScheme('https'); //カリキュラムにはないコード。
