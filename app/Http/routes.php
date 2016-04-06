<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //$projects = \App\Project::all();
    return view('welcome');
        //->with('projects', $projects);
});
/*
 * Routes para os Users.
 *
 */
// URL: /users ALIAS INTERNO: 'get.users' CONTROLADOR: UsersController FUNÇÃO: getAll
Route::get('users', ['as' => 'get.users', 'uses' => 'UsersController@getAll']);
// URL: /users/username ALIAS INTERNO: 'get.users' CONTROLADOR: UsersController FUNÇÃO: getUser
Route::get('users/{username}', ['as' => 'get.users.single', 'uses' => 'UsersController@getUser']);

Route::post('users/{username}', ['as' => 'post.users', 'uses' => 'UsersController@postUser']);
Route::put('users', ['as' => 'put.users', 'uses' => 'UsersController@putUser']);
Route::delete('users/{username}', ['as' => 'delete.users', 'users' => 'UsersController@deleteUser']);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
