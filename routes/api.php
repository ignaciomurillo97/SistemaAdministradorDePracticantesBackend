<?php

use Illuminate\Http\Request;
use App\Controller\AuthenticationController;

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


Route::post('/login', "AuthenticationController@login");

// Career
Route::get('/careers', "CareerController@all");
Route::get('/career/{id}', "CareerController@index");
Route::post('/career', "CareerController@store")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/career/{id}', "CareerController@update")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::delete('/career/{id}', "CareerController@destroy")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

// Site
Route::get('/sites', "SiteController@all");
Route::get('/site/{id}', "SiteController@index");
Route::post('/site', "SiteController@store")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/site/{id}', "SiteController@update")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::delete('/site/{id}', "SiteController@destroy")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

// Student
Route::get('/students', 'StudentController@all')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,student');
Route::post('/student', "StudentController@store")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,student');
Route::get('/student/aproved', "StudentController@getAproved")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/student/{id}', 'StudentController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,student');
Route::put('/student/{id}', "StudentController@update")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::delete('/student/{id}', "StudentController@destroy")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::post('/student/{id}/aprove', "StudentController@aproveStudent")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::post('/student/{id}/reject', "StudentController@rejectStudent")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

//Events
Route::resource('events','EventController')
	->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::resource('eventTypes','EventTypeController');
Route::get('/events/confirm/{event}','EventController@confirmAssistance')
	->middleware('auth:api');

Route::resource('activities','ActivityController');
Route::resource('companies','CompanyController');

//Mails
Route::get('/mail/send/{mail}','EmailController@send')
	->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/mail','EmailController@index')
	->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/mail/notify','EmailController@notifyEvent')
	->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

