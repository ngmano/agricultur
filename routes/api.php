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

Route::group(['namespace' => 'Api'], function() {
    Route::post('login', 'AuthController@login');
    Route::post('test', 'AuthController@test');
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::apiResources([
            'user' => 'UserController',
            'field' => 'FieldController',
            'tractor' => 'TractorController',
            'process-field' => 'ProcessFieldController'
        ]);

        Route::post('process-field/change-status', 'ProcessFieldController@changeStatus');
        Route::get('report', 'ReportController@index');
        Route::get('logout', 'UserController@logout');
        
    }); 
});
