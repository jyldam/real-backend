<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@create');

Route::get('housing-category', 'HousingCategoryController@indexGuest');

Route::get('housing', 'HousingController@index');

Route::middleware('auth:api')
    ->prefix('auth')
    ->group(function () {
        Route::delete('login', 'AuthController@destroy');
        Route::get('me', 'AuthController@me');

        Route::get('employee', 'EmployeeController@index');

        Route::get('housing-category', 'HousingCategoryController@indexAuthenticated');
        Route::post('housing-category', 'HousingCategoryController@create');
        Route::put('housing-category/{category}', 'HousingCategoryController@update');
        Route::delete('housing-category/{category}', 'HousingCategoryController@destroy');
    });
