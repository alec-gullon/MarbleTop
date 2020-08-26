<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        return view('recipes.index', [
            'featuredRecipe' => Recipe::find(config('marbletop.featured_recipe'))
        ]);
    }

    public function show($slug)
    {
        return view('recipes.show', [
            'recipe' => Recipe::where('slug', $slug)->first()
        ]);
    }
}
