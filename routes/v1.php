<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@store');

Route::get('housing-category', 'HousingCategoryController@index');
Route::get('housing-category/{category}', 'HousingCategoryController@show');

Route::get('housing', 'HousingController@index');
Route::get('housing/{housing}', 'HousingController@show')
    ->middleware('can:view,housing');

Route::get('giving-type', 'GivingTypeController@index');

Route::get('characteristic-category/{housingCategory}', 'CharacteristicCategoryController@index');

Route::get('employee', 'EmployeeController@index');
Route::get('employee/{employee}', 'EmployeeController@show');

Route::post('call-back', 'CallBackController@store');

Route::get('region', 'RegionController@index');

Route::post('housing/report', 'HousingReportController@store');

Route::get('housing/filter/{category}', 'HousingFilterController@index');

Route::middleware('auth:api')
    ->prefix('auth')
    ->group(function () {
        Route::delete('login', 'AuthController@destroy');
        Route::get('me', 'AuthController@me');

        Route::post('employee', 'EmployeeController@store')
            ->middleware('can:create,App\Models\Employee');
        Route::patch('employee/{employee}', 'EmployeeController@update')
            ->middleware('can:update,employee');
        Route::delete('employee/{employee}', 'EmployeeController@destroy')
            ->middleware('can:delete,employee');

        Route::get('housing/report', 'HousingReportController@index');
        Route::patch('housing/report/{housingReport}', 'HousingReportController@update');
        Route::delete('housing/report/{housingReport}', 'HousingReportController@destroy');

        Route::post('housing', 'HousingController@store')
            ->middleware('can:create,App\Models\Housing');
        Route::patch('housing/{housing}', 'HousingController@update')
            ->middleware('can:update,housing');
        Route::delete('housing/{housing}', 'HousingController@destroy')
            ->middleware('can:delete,housing');

        Route::get('call-back', 'CallBackController@index');
        Route::patch('call-back/{callBack}', 'CallBackController@update');
        Route::delete('call-back/{callBack}', 'CallBackController@destroy');
    });
