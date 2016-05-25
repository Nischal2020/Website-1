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
	Route::post('users', ['as' => 'post.users', 'uses' => 'UsersController@postUser']);
	Route::put('users/{identification}', ['as' => 'put.users', 'uses' => 'UsersController@putUser']);
	Route::delete('users/{identification}', ['as' => 'delete.users', 'uses' => 'UsersController@deleteUser']);
	//Event_User table routes
	Route::get('users/{identification}/events', ['as' => 'get.users.events', 'uses' => 'UsersController@getEvents']);
	
	/*
	 * Roles Routes
	 */
	Route::get('roles', ['as' => 'get.roles', 'uses' => 'RolesController@getAll']);
	Route::get('roles/{id}', ['as' => 'get.roles.single', 'uses' => 'RolesController@getRole']);
	Route::post('roles', ['as' => 'post.roles', 'uses' => 'RolesController@postRole']);
	Route::put('roles/{id}', ['as' => 'put.roles', 'uses' => 'RolesController@putRole']);
	Route::delete('roles/{id}', ['as' => 'delete.roles', 'uses' => 'RolesController@deleteRole']);

	/*
	 * Courses Routes
	 */
	Route::get('courses', ['as' => 'get.courses', 'uses' => 'CoursesController@getAll']);
	Route::get('courses/{id}', ['as' => 'get.courses.single', 'uses' => 'CoursesController@getCourse']);
	Route::post('courses', ['as' => 'post.courses', 'uses' => 'CoursesController@postCourse']);
	Route::put('courses/{id}', ['as' => 'put.courses', 'uses' => 'CoursesController@putCourse']);
	Route::delete('courses/{id}', ['as' => 'delete.courses', 'uses' => 'CoursesController@deleteCourse']);

	/*
	 * Requisitions Routes
	 */
	Route::get('requisitions', ['as' => 'get.requisitions', 'uses' => 'RequisitionsController@getAll']);
	Route::get('requisitions/{id}', ['as' => 'get.requisitions.single', 'uses' => 'RequisitionsController@getRequisition']);
	Route::post('requisitions', ['as' => 'post.requisitions', 'uses' => 'RequisitionsController@postRequisition']);
	Route::put('requisitions/{id}', ['as' => 'put.requisitions', 'uses' => 'RequisitionsController@putRequisition']);
	Route::delete('requisitions/{id}', ['as' => 'delete.requisitions', 'uses' => 'RequisitionsController@deleteRequisition']);

	/*
	 * Programming_Languages Routes
	 */
	Route::get('programming_languages', ['as' => 'get.programming_languages', 'uses' => 'ProgrammingLanguagesController@getAll']);
	Route::get('programming_languages/{id}', ['as' => 'get.programming_languages.single', 'uses' => 'ProgrammingLanguagesController@getProgrammingLanguage']);
	Route::post('programming_languages', ['as' => 'post.programming_languages', 'uses' => 'ProgrammingLanguagesController@postProgrammingLanguage']);
	Route::put('programming_languages/{id}', ['as' => 'put.programming_languages', 'uses' => 'ProgrammingLanguagesController@putProgrammingLanguage']);
	Route::delete('programming_languages/{id}', ['as' => 'delete.programming_languages', 'uses' => 'ProgrammingLanguagesController@deleteProgrammingLanguage']);

	/*
	 * Organizations Routes
	 */
	Route::get('organizations', ['as' => 'get.organizations', 'uses' => 'OrganizationsController@getAll']);
	Route::get('organizations/{id}', ['as' => 'get.organizations.single', 'uses' => 'OrganizationsController@getOrganization']);
	Route::post('organizations', ['as' => 'post.organizations', 'uses' => 'OrganizationsController@postOrganization']);
	Route::put('organizations/{id}', ['as' => 'put.organizations', 'uses' => 'OrganizationsController@putOrganization']);
	Route::delete('organizations/{id}', ['as' => 'delete.organizations', 'uses' => 'OrganizationsController@deleteOrganization']);

	/*
	 * Materials Routes
	 */
	Route::get('materials', ['as' => 'get.materials', 'uses' => 'MaterialsController@getAll']);
	Route::get('materials/{id}', ['as' => 'get.materials.single', 'uses' => 'MaterialsController@getMaterial']);
	Route::post('materials', ['as' => 'post.materials', 'uses' => 'MaterialsController@postMaterial']);
	Route::put('materials/{id}', ['as' => 'put.materials', 'uses' => 'MaterialsController@putMaterial']);
	Route::delete('materials/{id}', ['as' => 'delete.materials', 'uses' => 'MaterialsController@deleteMaterial']);

	/*
	 * Events Routes
	 */
	Route::get('events', ['as' => 'get.events', 'uses' => 'EventsController@getAll']);
	Route::get('events/{id}', ['as' => 'get.events.single', 'uses' => 'EventsController@getEvent']);
	Route::post('events', ['as' => 'post.events', 'uses' => 'EventsController@postEvent']);
	Route::put('events/{id}', ['as' => 'put.events', 'uses' => 'EventsController@putEvent']);
	Route::delete('events/{id}', ['as' => 'delete.events', 'uses' => 'EventsController@deleteEvent']);

	/*
	 * Guests Routes
	 */
	Route::get('guests', ['as' => 'get.guests', 'uses' => 'GuestsController@getAll']);
	Route::get('guests/{id}', ['as' => 'get.guests.single', 'uses' => 'GuestsController@getGuest']);
	Route::post('guests', ['as' => 'post.guests', 'uses' => 'GuestsController@postGuest']);
	Route::put('guests/{id}', ['as' => 'put.guests', 'uses' => 'GuestsController@putGuest']);
	Route::delete('guests/{id}', ['as' => 'delete.guests', 'uses' => 'GuestsController@deleteGuest']);

	/*
	 * Projects Routes
	 */
	Route::get('projects', ['as' => 'get.projects', 'uses' => 'ProjectsController@getAll']);
	Route::get('projects/{id}', ['as' => 'get.projects.single', 'uses' => 'ProjectsController@getProject']);
	Route::post('projects', ['as' => 'post.projects', 'uses' => 'ProjectsController@postProject']);
	Route::put('projects/{id}', ['as' => 'put.projects', 'uses' => 'ProjectsController@putProject']);
	Route::delete('projects/{id}', ['as' => 'delete.projects', 'uses' => 'ProjectsController@deleteProject']);
	//Organization_Project table routes
	Route::get('projects/{id}/organizations', ['as' => 'get.projects.organizations', 'uses' => 'ProjectsController@getOrganizations']);
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
