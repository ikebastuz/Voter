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

Route::get('/dashboard', 'DashboardController@dashboard');
Route::get('/', 'DashboardController@dashboard');
Route::get('/votelist', 'DashboardController@voteList');

Route::get('/createvote', 'PostController@createVote');
Route::post('/createvote', 'PostController@postCreateVote');

Route::get('/vote/{id}', 'DashboardController@viewVote');
Route::get('/vote/{id}/edit', 'PostController@editVote');
Route::get('/vote/{id}/stats', 'DashboardController@viewStatsVote');
Route::post('/updatevote/{id}', 'PostController@updateVote');
Route::get('/vote/{id}/rename', 'PostController@renameVote');
Route::post('/vote/updaterename/{id}', 'PostController@postRenameVote');
Route::get('/vote/{id}/delete', 'PostController@deleteVote');

Route::get('/activate/{id}', 'PostController@activate');

Route::get('/deletesvote/{id}', 'PostController@deleteSVote');

Route::post('/makechoise', 'PostController@makeChoise');
Route::post('/revote', 'PostController@reVote');
