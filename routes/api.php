<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/items/store/', 'Api\ItemController@store')->name('store-item');
    Route::post('/items/{item}/update/', 'Api\ItemController@update')->name('update-item');
    Route::post('/items/{item}/destroy/', 'Api\ItemController@destroy')->name('destroy-item');

    Route::post('/meals/store/', 'Api\MealController@store')->name('store-meal');
    Route::post('/meals/{meal}/update', 'Api\MealController@update')->name('update-meal');
    Route::post('/meals/{meal}/destroy', 'Api\MealController@destroy')->name('destroy-meal');

    Route::post('/groups/store/', 'Api\GroupController@store')->name('store-group');
    Route::post('/groups/{group}/update/', 'Api\GroupController@update')->name('update-group');
    Route::post('/groups/{group}/destroy/', 'Api\GroupController@destroy')->name('destroy-group');

    Route::post('/plans/store', 'Api\PlanController@store')->name('store-plan');
});
