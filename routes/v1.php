<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@store');

Route::get('housing-category', 'HousingCategoryController@index');
Route::get('housing-category/{category}', 'HousingCategoryController@show');

Route::get('housing', 'HousingController@index');
Route::get('housing/{housing}', 'HousingController@show');

Route::get('giving-type', 'GivingTypeController@index');

Route::get('characteristic-category/{housingCategory}', 'CharacteristicCategoryController@index');

Route::get('employee', 'EmployeeController@index');
Route::get('employee/{employee}', 'EmployeeController@show');

Route::post('call-back', 'CallBackController@store');

Route::get('region', 'RegionController@index');

Route::middleware('auth:api')
    ->prefix('auth')
    ->group(function () {
        Route::delete('login', 'AuthController@destroy');
        Route::get('me', 'AuthController@me');

        Route::post('employee', 'EmployeeController@store');
        Route::patch('employee/{employee}', 'EmployeeController@update');
        Route::delete('employee/{employee}', 'EmployeeController@destroy');

        Route::get('housing/report', 'HousingReportController@index');

        Route::post('housing', 'HousingController@store');
        Route::patch('housing/{housing}', 'HousingController@update');
        Route::delete('housing/{housing}', 'HousingController@destroy');

        Route::get('call-back', 'CallBackController@index');
    });
