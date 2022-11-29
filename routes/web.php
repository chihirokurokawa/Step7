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

//一覧を表示
Route::get('/', 'MgtController@showList')->name('mgts');
//登録画面の表示
Route::get('/product/create', 'MgtController@showCreate')->name('create');
//商品登録
Route::post('/product/store', 'MgtController@exeStore')->name('store');
//詳細を表示
Route::get('/product/{id}', 'MgtController@showDetail')->name('show');

// 一覧表示のリレーション
Route::get('product/list','ProductController@select');
// 詳細表示のリレーション
Route::get('product/detail','ProductController@select');
// 商品編集画面の表示
Route::get('product/edit/{id}','MgtController@showEdit')->name('edit');
//　商品編集画面登録
Route::post('/product/update', 'MgtController@exeUpdate')->name('update');
// 商品情報削除
Route::post('/product/delate/{id}', 'MgtController@exeDelete')->name('delate');
Auth::routes();
//　商品結果画面
Route::post('/', 'MgtController@keyword')->name('mgts');
// 　商品検索画面
// Route::get('product/post', 'MgtController@post')->name('post');
