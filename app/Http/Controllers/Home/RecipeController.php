<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\Recipe;

use App\Vue\RecipeCreator;
use App\Vue\RecipeEditor;

class RecipeController extends Controller
{
    public function index()
    {
        return view('home.recipes.index');
    }

    public function add()
    {
        return view('home.recipes.create-recipe', [
            'items' => RecipeCreator::items()
        ]);
    }

    public function edit(Recipe $recipe)
    {
        return view('home.recipes.edit-recipe', [
            'recipe' => $recipe,
            'items' => RecipeEditor::items($recipe)
        ]);
    }
}
