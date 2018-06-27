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
Route::get('/adminpanel/users/data',function()
{
  dd('Ajax is worrking');
});

// posts routes
Route::get('/post', 'PostController@index')->middleware('auth');
Route::post('/post', 'PostController@store')->middleware('auth');
Route::get('/post/{id}', 'PostController@show')->name('post.show');
Route::get('/post/{id}/edit', 'PostController@edit')->name('post.edit')->middleware('auth');
Route::put('/post/{id}/edit', 'PostController@update')->name('post.update')->middleware('auth');
Route::delete('/post/{id}/delete', 'PostController@destroy')->name('post.delete')->middleware('auth');


// categories routes
Route::get('/category', 'CategoryController@index')->middleware('auth');
Route::post('/category', 'CategoryController@store')->middleware('auth');
Route::get('/post/category/{id}', 'CategoryController@showAll')->name('category.showAll')->middleware('auth');

// like dislike routes
Route::get('/like/{postID}/{userID}/','LikeController@addLike')->middleware('auth');
Route::get('/dislike/{postID}/{userID}/','LikeController@disLike')->middleware('auth');

// comments routes
Route::post('/comment',  'CommentController@store')->middleware('auth');
Route::put('/comment/{id}/edit', 'CommentController@update')->name('comment.update')->middleware('auth');
Route::delete('/comment/{id}/delete',  'CommentController@destroy')->name('comment.delete')->middleware('auth');


// replies routss
Route::post('/reply','ReplyController@store');
Route::put('/reply/{id}/update','ReplyController@update')->name('reply.update')->middleware('auth');
Route::delete('/reply/{id}/delete','ReplyController@destroy')->name('reply.delete')->middleware('auth');


Route::get('/users','HomeController@listUser');
Route::get('/users/{id}','HomeController@showUser')->name('user.show');

Route::post('/friend','FriendController@index')->middleware('auth');
