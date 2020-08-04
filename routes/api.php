<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/ingredients/store/', 'Api\IngredientController@store')->name('store-ingredient');
    Route::post('/ingredients/{ingredient}/update/', 'Api\IngredientController@update')->name('update-ingredient');
    Route::post('/ingredients/{ingredient}/destroy/', 'Api\IngredientController@destroy')->name('destroy-ingredient');

    Route::post('/meals/store/', 'Api\MealController@store')->name('store-meal');
    Route::post('/meals/{meal}/update', 'Api\MealController@update')->name('update-meal');
    Route::post('/meals/{meal}/destroy', 'Api\MealController@destroy')->name('destroy-meal');
});

Route::middleware('auth:api')->post('/groups/add/', 'Api\GroupController@add');
Route::middleware('auth:api')->post('/groups/{group}/update/', 'Api\GroupController@update');
Route::middleware('auth:api')->post('/groups/{group}/delete/', 'Api\GroupController@delete');

Route::middleware('auth:api')->post('/plans/add', 'Api\PlanController@add');
