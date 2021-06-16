<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| User Routes
|-------------------------------------------------------------------------- */

Route::resource('user','User\UserController')->except(['index','edit']);
Route::resource('user.posts','User\UserPostController')->only(['index']);
Route::resource('user.like','User\UserLikeController')->only(['index']);
Route::resource('user.comment','User\UserCommentController')->only(['index']);



/*
|--------------------------------------------------------------------------
| Post Routes
|-------------------------------------------------------------------------- */

Route::resource('posts','Post\PostController')->except(['edit','create']);
Route::put('post/{postId}/like','Post\PostLikeController@likeOrUnlike');
Route::get('post/{postId}/like','Post\PostLikeController@index');
Route::resource('post.comment','Post\PostCommentController')->only(['index','store']);


/*
|--------------------------------------------------------------------------
| Comment Routes
|-------------------------------------------------------------------------- */
Route::put('/comment/{commentId}/likes','Comment\CommentLikeController@likeOrUnlike');
Route::get('/comment/{commentId}/likes','Comment\CommentLikeController@index');
Route::resource('comment','Comment\CommentController')->only(['update','destroy']);