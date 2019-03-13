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

Route::resource('events','EventController');
Route::resource('types','EventTypeController');

Route::resource('activities','ActivityController');
Route::resource('companies','CompanyController');
