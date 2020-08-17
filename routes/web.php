<?php

/** Pages */

Route::get('/',                         'PageController@index')->name('homepage');
Route::get('/accounts/create',          'PageController@createAccount')->name('create-account');
Route::get('/about',                    'PageController@about')->name('about');

/** Authentication */

Route::get('/login',                    'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login',                   'Auth\LoginController@login')->name('attempt-login');
Route::post('/logout',                  'Auth\LoginController@logout')->name('logout');

/** Home */

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home',                         'HomeController@index')->name('home');

    Route::get('/home/items',                  'Home\ItemController@index')->name('items');

    Route::get('/home/recipes',                  'Home\RecipeController@index')->name('recipes');
    Route::get('/home/recipes/create',           'Home\RecipeController@add')->name('recipes-add');
    Route::get('/home/recipes/{recipe}',           'Home\RecipeController@recipe')->name('recipe-details');
    Route::get('/home/recipes/{recipe}/edit',      'Home\RecipeController@edit')->name('recipe-edit');

    Route::get('/home/collections',            'Home\CollectionController@index')->name('collections');
    Route::get('/home/collections/create',     'Home\CollectionController@show')->name('collections-add');
    Route::get('/home/collections/{collection}',    'Home\CollectionController@edit')->name('collections-edit');

    Route::get('/home/plans',                  'Home\PlanController@index')->name('plans');
    Route::get('/home/plans/create',           'Home\PlanController@add')->name('plans-add');
    Route::get('/home/plans/{plan}',            'Home\PlanController@show')->name('plan');
});


