<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class IngredientController extends Controller
{
    public function index()
    {
        $locations = \App\Helper::locationsData();
        $ingredientsData = \App\Helper::ingredientsData(auth()->user());

        return view('home.ingredients', compact('locations', 'ingredientsData'));
    }
}
