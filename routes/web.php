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


Route::group(['middleware'=>['auth']],function(){


// posts routes
Route::get('/post', 'PostController@index')->name('posts.index');
Route::post('/post', 'PostController@store')->name('posts.store');
Route::get('/post/{id}', 'PostController@show')->name('posts.show');
Route::get('/post/{id}/edit', 'PostController@edit')->name('posts.edit');
Route::put('/post/{id}/edit', 'PostController@update')->name('posts.update');
Route::delete('/post/{id}/delete', 'PostController@destroy')->name('posts.delete');


// categories routes
Route::get('/category', 'CategoryController@index')->name('categories.index');
Route::post('/category', 'CategoryController@store')->name('categories.store');
Route::get('/post/category/{id}', 'CategoryController@showAll')->name('categories.showAll');



// like dislike routes
Route::get('/like/{postID}/{userID}/','LikeController@addLike')->name('addlike');
Route::get('/dislike/{postID}/{userID}/','LikeController@disLike')->name('dislike');

// comments routes
Route::post('/comment',  'CommentController@store')->name('comments.store');
Route::put('/comment/{id}/edit', 'CommentController@update')->name('comments.update');
Route::delete('/comment/{id}/delete',  'CommentController@destroy')->name('comments.delete');


// replies routs
Route::post('/reply','ReplyController@store')->name('replies.store');
Route::put('/reply/{id}/update','ReplyController@update')->name('replies.update');
Route::delete('/reply/{id}/delete','ReplyController@destroy')->name('replies.delete');

// users routes
Route::get('/users','HomeController@listUser')->name('users.index');
Route::get('/users/{id}','HomeController@showUser')->name('users.show');

Route::post('/friend','FriendController@index');

});
