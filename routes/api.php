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

Route::post('/administrator/login', "AuthenticationController@login")->defaults('scope', 'super-user');
Route::post('/coordinator/login', "AuthenticationController@login")->defaults('scope', 'coordinator');
Route::post('/student/login', "AuthenticationController@login")->defaults('scope', 'student');
Route::post('/company/login', "AuthenticationController@login")->defaults('scope', 'company');

// Career
Route::get('/careers', "CareerController@all");
Route::get('/career/{id}', "CareerController@index");
Route::put('/career', "CareerController@store");
Route::post('/career/{id}', "CareerController@update");
Route::delete('/career/{id}', "CareerController@destroy");

// Site
Route::get('/sites', "SiteController@all");
Route::get('/site/{id}', "SiteController@index");
Route::put('/site', "SiteController@store");
Route::post('/site/{id}', "SiteController@update");
Route::delete('/site/{id}', "SiteController@destroy");
