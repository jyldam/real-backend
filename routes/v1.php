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

Route::post('call-back', 'CallBackController@store');

Route::middleware('auth:api')
    ->prefix('auth')
    ->group(function () {
        Route::delete('login', 'AuthController@destroy');
        Route::get('me', 'AuthController@me');

        Route::post('employee', 'EmployeeController@store');
        Route::patch('employee/{employee}', 'EmployeeController@update');

        Route::post('housing', 'HousingController@store');
    });
