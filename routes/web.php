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


Auth::routes();

Route::get('/dashboard', ['uses' => 'DashboardController@dashboard', 'as' => 'dashboard']);
Route::get('/', ['uses' => 'DashboardController@dashboard', 'as' => 'dashboard']);
Route::get('/votelist', ['uses' => 'DashboardController@voteList', 'as' => 'votelist']);

Route::get('/createvote', ['uses' =>'PostController@createVote', 'as' => 'createVote']);
Route::post('/createvote', ['uses' => 'PostController@postCreateVote', 'as' => 'postCreatePost']);

Route::get('/vote/{id}', ['uses' => 'DashboardController@viewVote', 'as' => 'viewVote']);
Route::get('/vote/{id}/edit', ['uses' => 'PostController@editVote' , 'as' => 'voteEdit']);
Route::get('/vote/{id}/stats', ['uses' => 'DashboardController@viewStatsVote', 'as' => 'voteStats']);
Route::post('/updatevote/{id}', ['uses' => 'PostController@updateVote', 'as' => 'updateVote']);
Route::get('/vote/{id}/rename', ['uses' => 'PostController@renameVote', 'as' => 'voteRename']);
Route::post('/vote/updaterename/{id}', ['uses' => 'PostController@postRenameVote', 'as' => 'updateRename']);

Route::get('/vote', ['uses' =>'PostController@deleteVote', 'as' => 'voteDelete']);
Route::get('/vote/{id}/delete', ['uses' =>'PostController@deleteVote', 'as' => 'voteIdDelete']);

Route::get('/activate/{id}', ['uses' => 'PostController@activate', 'as' => 'activate']);

Route::get('/deletesvote', ['uses' => 'PostController@deleteSVote', 'as' => 'voteSDelete']);
Route::get('/deletesvote/{id}', ['uses' => 'PostController@deleteSVote', 'as' => 'voteIdDelete']);

Route::post('/makechoise', ['uses' => 'PostController@makeChoise', 'as' => 'makeChoice']);
Route::post('/revote', ['uses' => 'PostController@reVote', 'as' => 'revote']);
