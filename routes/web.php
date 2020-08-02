<?php

/** Pages */

Route::get('/',                         'PageController@index')->name('homepage');
Route::get('/accounts/create',          'PageController@createAccount')->name('create-account');

/** Authentication */

Route::get('/login',                    'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login',                   'Auth\LoginController@login')->name('attempt-login');
Route::post('/logout',                  'Auth\LoginController@logout')->name('logout');

/** Home */

Route::get('/home',                     'HomeController@index')->name('home');
Route::get('/home/meals/',              'HomeController@meals')->name('meals');
Route::get('/home/groups/',             'HomeController@groups')->name('groups');
Route::get('/home/plans/',              'HomeController@plans')->name('plans');

Route::get('/home/ingredients/',        'Home\IngredientController@index')->name('ingredients');

Route::get('/home/meals/create/',       'Home\MealController@add')->name('meals-add');
Route::get('/home/meals/{meal}/',       'Home\MealController@meal')->name('meal-details');
Route::get('/home/meals/{meal}/edit/',  'Home\MealController@edit')->name('meal-edit');

Route::get('/home/groups/create/',      'Home\GroupController@add')->name('groups-add');
Route::get('/home/groups/{group}/',     'Home\GroupController@edit')->name('group-edit');

Route::get('/home/plans/create/',       'Home\PlanController@add')->name('plans-add');


