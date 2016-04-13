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

//API routes
Route::group(['prefix' => 'api/v1'], function() {

	/*
	 * Routes para os Users.
	 */
	// URL: /users ALIAS INTERNO: 'get.users' CONTROLADOR: UsersController FUNÇÃO: getAll
	Route::get('users', ['as' => 'get.users', 'uses' => 'UsersController@getAll']);
	// URL: /users/username ALIAS INTERNO: 'get.users.single' CONTROLADOR: UsersController FUNÇÃO: getUser
	Route::get('users/{identification}', ['as' => 'get.users.single', 'uses' => 'UsersController@getUser']);
	Route::post('users/{identification}', ['as' => 'post.users', 'uses' => 'UsersController@postUser']);
	Route::put('users', ['as' => 'put.users', 'uses' => 'UsersController@putUser']);
	Route::delete('users/{identification}', ['as' => 'delete.users', 'uses' => 'UsersController@deleteUser']);


	/*
	 * Role Routes
	 */
	Route::get('roles', ['as' => 'get.roles', 'uses' => 'RolesController@getAll']);
	Route::get('roles/{id}', ['as' => 'get.roles.single', 'uses' => 'RolesController@getRole']);
	Route::post('roles/{id}', ['as' => 'post.roles', 'uses' => 'RolesController@postRole']);
	Route::put('roles', ['as' => 'put.roles', 'uses' => 'RolesController@putRole']);
	Route::delete('roles/{id}', ['as' => 'delete.roles', 'uses' => 'RolesController@deleteRole']);



});


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


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
