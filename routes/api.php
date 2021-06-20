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
*/


//User Related
Route::post('user/profile/register','User\UserController@store');
Route::post('user/profile/login','User\UserController@login');

//Post Related
Route::get('post/{post_id}/show','Post\PostController@show');
Route::get('post/{post_id}/comments','Post\PostCommentController@index');
Route::get('post/{postId}/likes','Post\PostLikeController@index');

//Comment Related
Route::get('comment/{commentId}/likes','Comment\CommentLikeController@index');
Route::get('comment/{commentId}/replies','Comment\CommentReplyController@index');



/*
|--------------------------------------------------------------------------
| Auth Routes
|-------------------------------------------------------------------------- */

Route::group([
    'middleware' => 'api',
    'prefix' =>'auth'
],function()
{

//User Related

Route::put('user/profile/update','User\UserController@update');
Route::get('user/logout','User\UserController@logout');
Route::get('user/profile/refresh','User\UserController@reload');
Route::delete('user/profile/delete','User\UserController@destroy');
Route::get('user/profile','User\UserController@show');
Route::get('user/posts','User\UserPostController@index');
Route::get('user/likes','User\UserLikeController@index');
Route::get('user/comments','User\UserCommentController@index');

//Post Related

Route::post('post/create','Post\PostController@store');
Route::put('post/{postId}/update','Post\PostController@update');
Route::delete('post/{postId}/delete','Post\PostController@update');
Route::post('post/{postId}/comment','Post\PostCommentController@store');
Route::put('post/{postId}/like','Post\PostLikeController@likeOrUnlike');

//Comment related

Route::put('comment/{commentId}/update','Comment\CommentController@update');
Route::delete('comment/{commenId}/delete','Comment\CommentController@delete');
Route::put('comment/{commentId}/like','Comment\CommentLikeController@likeOrUnlike');
Route::post('comment/{commentId}/reply','Comment\CommentReplyController@store');








});