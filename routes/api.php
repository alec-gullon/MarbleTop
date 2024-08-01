<?php

use App\Http\Controllers\Api\CollectionController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/items/store',                         [ItemController::class, 'store'])->name('store-item');
    Route::post('/items/{item}/update',                 [ItemController::class, 'update'])->name('update-item');
    Route::post('/items/{item}/destroy',                [ItemController::class, 'destroy'])->name('destroy-item');

    Route::post('/recipes/store',                       [RecipeController::class, 'store'])->name('store-recipe');
    Route::post('/recipes/{recipe}/update',             [RecipeController::class, 'update'])->name('update-recipe');
    Route::post('/recipes/{recipe}/destroy',            [RecipeController::class, 'destroy'])->name('destroy-recipe');

    Route::post('/recipes/{recipe}/status/toggle',      [RecipeController::class, 'togglePublishStatus'])->name('recipe-toggle-publish');

    Route::post('/collections/store',                   [CollectionController::class, 'store'])->name('store-collection');
    Route::post('/collections/{collection}/update',     [CollectionController::class, 'update'])->name('update-collection');
    Route::post('/collections/{collection}/destroy',    [CollectionController::class, 'destroy'])->name('destroy-collection');

    Route::post('/plans/store',                         [PlanController::class, 'store'])->name('store-plan');
});
