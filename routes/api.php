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
Route::post('/student', "StudentController@store");
Route::get('/students/aproved', "StudentController@filterByStatus")
    ->defaults('status', 1)
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/students/pending', "StudentController@filterByStatus")
    ->defaults('status', 2)
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/students/rejected', "StudentController@filterByStatus")
    ->defaults('status', 3)
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
Route::post('/students/assign/{student}/{professor}','StudentController@assignProfessor')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

// Catalogs
Route::get('/catalog/gender', "CatalogController@getGender");
Route::get('/catalog/semester', "CatalogController@getSemester");
Route::get('/catalog/scope', "CatalogController@getScope")
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

//Events
Route::post('/events','EventController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/events','EventController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,student,company');
Route::get('/events/{id}','EventController@show')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,student,company');
Route::post('/events/{id}','EventController@update')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

Route::resource('eventTypes','EventTypeController');
Route::get('/events/confirm/{event}','EventController@confirmAssistance')
	->middleware('auth:api');

//Suggestions
Route::post('/suggestions','SuggestionController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,company');
Route::get('/suggestions','SuggestionController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,company');
Route::get('/suggestions/{id}','SuggestionController@show')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,company');

// Activities
Route::post('/activities','ActivityController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
//Route::resource('activities','ActivityController');
Route::resource('suggestions','SuggestionController');

// Companies
Route::get('/companies', 'CompanyController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,company');
Route::post('/companies','CompanyController@store');
Route::get('/company/{id}', 'CompanyController@show')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/company/site-career-request', 'CompanyController@requestRegistrationToCareer')
    ->middleware('auth:api')
    ->middleware('scope:company');
Route::get('/companies/requests', 'CompanyController@getRegistrationRequest')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/companies/requests/{id}/aprove', 'CompanyController@aproveRegistration')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/companies/requests/{id}/deny', 'CompanyController@denyRegistration')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

//Mails
Route::get('/mail/send/{mail}','EmailController@send')
	->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/mail','EmailController@index');
Route::get('/mail/notify','EmailController@notifyEvent')
	->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

//Semester
Route::get('/semester', 'SemesterController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::post('/semester', 'SemesterController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/semester/{id}', 'SemesterController@show')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/semester/{id}', 'SemesterController@update')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::delete('/semester/{id}', 'SemesterController@destroy')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');


Route::post('/document','DocumentController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

Route::delete('/document/{id}','DocumentController@destroy')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

Route::post('/uploadcharter','DocumentController@uploadCharter')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator,student');

// Professor
Route::get('/professor', 'ProfessorController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::post('/professor', 'ProfessorController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/professor/{id}', 'ProfessorController@show')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/professor/{id}', 'ProfessorController@update')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::delete('/professor/{id}', 'ProfessorController@destroy')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

Route::post('/assignCharterGrade/{id}', 'StudentController@assignCharterGrade');
Route::get('/showCharterGrade', 'StudentController@showCharterGrade');

// Coordinator
Route::get('/coordinator', 'CoordinatorController@index')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::post('/coordinator', 'CoordinatorController@store')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::get('/coordinator/{id}', 'CoordinatorController@show')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::put('/coordinator/{id}', 'CoordinatorController@update')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');
Route::delete('/coordinator/{id}', 'CoordinatorController@destroy')
    ->middleware('auth:api')
    ->middleware('scope:super-user,coordinator');

Route::get('/peoplePerSemester','StaticsController@peoplePerSemester');