<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->post('/ingredients/add/', 'Api\IngredientController@add');
Route::middleware('auth:api')->post('/ingredients/update/', 'Api\IngredientController@update');
Route::middleware('auth:api')->post('/ingredients/remove/', 'Api\IngredientController@delete');

Route::middleware('auth:api')->post('/meals/add/', 'Api\MealController@add');
Route::middleware('auth:api')->post('/meals/{meal}/update', 'Api\MealController@update');
Route::middleware('auth:api')->post('/meals/{meal}/delete', 'Api\MealController@delete');

Route::middleware('auth:api')->post('/groups/add/', 'Api\GroupController@add');
Route::middleware('auth:api')->post('/groups/{group}/update/', 'Api\GroupController@update');
Route::middleware('auth:api')->post('/groups/{group}/delete/', 'Api\GroupController@delete');

Route::middleware('auth:api')->post('/plans/add', 'Api\PlanController@add');
