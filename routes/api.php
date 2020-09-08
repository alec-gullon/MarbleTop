<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/items/store', 'Api\ItemController@store')->name('store-item');
    Route::post('/items/{item}/update', 'Api\ItemController@update')->name('update-item');
    Route::post('/items/{item}/destroy', 'Api\ItemController@destroy')->name('destroy-item');

    Route::post('/recipes/store', 'Api\RecipeController@store')->name('store-recipe');
    Route::post('/recipes/{recipe}/update', 'Api\RecipeController@update')->name('update-recipe');
    Route::post('/recipes/{recipe}/destroy', 'Api\RecipeController@destroy')->name('destroy-recipe');

    Route::post('/recipes/{recipe}/status/toggle', 'Api\RecipeController@togglePublishStatus')->name('recipe-toggle-publish');

    Route::post('/collections/store', 'Api\CollectionController@store')->name('store-collection');
    Route::post('/collections/{collection}/update', 'Api\CollectionController@update')->name('update-collection');
    Route::post('/collections/{collection}/destroy', 'Api\CollectionController@destroy')->name('destroy-collection');

    Route::post('/plans/store', 'Api\PlanController@store')->name('store-plan');
});
