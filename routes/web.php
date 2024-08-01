<?php

// Pages

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Home\CollectionController;
use App\Http\Controllers\Home\ItemController;
use App\Http\Controllers\Home\PlanController;
use App\Http\Controllers\Home\RecipeController as HomeRecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/',                         [PageController::class, 'index'])->name('homepage');
Route::get('/accounts/create',          [PageController::class, 'createAccount'])->name('create-account');
Route::get('/about',                    [PageController::class, 'about'])->name('about');

// Authentication

Route::get('/login',                    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',                   [LoginController::class, 'login'])->name('attempt-login');
Route::post('/logout',                  [LoginController::class, 'logout'])->name('logout');

// Recipes

Route::get('/recipes',                  [RecipeController::class, 'index'])->name('public-recipes');
Route::get('/recipes/{slug}',           [RecipeController::class, 'show'])->name('public-recipe');

// Home

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home',                             [HomeController::class, 'index'])->name('home');

    Route::get('/home/items',                       [ItemController::class, 'index'])->name('items');

    Route::get('/home/recipes',                     [HomeRecipeController::class, 'index'])->name('recipes');
    Route::get('/home/recipes/create',              [HomeRecipeController::class, 'add'])->name('recipes-add');
    Route::get('/home/recipes/{recipe}',            [HomeRecipeController::class, 'edit'])->name('recipe-edit');

    Route::get('/home/collections',                 [CollectionController::class, 'index'])->name('collections');
    Route::get('/home/collections/create',          [CollectionController::class, 'show'])->name('collections-add');
    Route::get('/home/collections/{collection}',    [CollectionController::class, 'edit'])->name('collections-edit');

    Route::get('/home/plans',                       [PlanController::class, 'index'])->name('plans');
    Route::get('/home/plans/create',                [PlanController::class, 'add'])->name('plans-add');
    Route::get('/home/plans/{plan}',                [PlanController::class, 'show'])->name('plan');
});


