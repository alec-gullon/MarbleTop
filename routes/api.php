<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/ingredients/add/', 'Api\IngredientController@store')->name('add-ingredient');
    Route::post('/ingredients/{ingredient}/update/', 'Api\IngredientController@update')->name('update-ingredient');
    Route::post('/ingredients/{ingredient}/remove/', 'Api\IngredientController@destroy')->name('destroy-ingredient');
});

Route::middleware('auth:api')->post('/meals/add/', 'Api\MealController@add');
Route::middleware('auth:api')->post('/meals/{meal}/update', 'Api\MealController@update');
Route::middleware('auth:api')->post('/meals/{meal}/delete', 'Api\MealController@delete');

Route::middleware('auth:api')->post('/groups/add/', 'Api\GroupController@add');
Route::middleware('auth:api')->post('/groups/{group}/update/', 'Api\GroupController@update');
Route::middleware('auth:api')->post('/groups/{group}/delete/', 'Api\GroupController@delete');

Route::middleware('auth:api')->post('/plans/add', 'Api\PlanController@add');
