<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::post('/', 'UsersController@signIn');
});

Route::prefix('repositories')->group(function () {
    Route::get('/', 'RepositoriesController@index');
    Route::get('commits', 'RepositoriesController@commits');
    Route::post('{username}/{repository}', 'RepositoriesController@add');
    Route::get('{username}/{repository}/commits', 'RepositoriesController@repositoryCommits');
});
