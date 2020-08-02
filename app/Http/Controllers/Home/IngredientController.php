<?php

namespace App\Http\Controllers\Home;

use Illuminate\Routing\Controller as BaseController;

class IngredientController extends BaseController {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $locations = \App\Helper::locationsData();
        $ingredientsData = \App\Helper::ingredientsData(auth()->user());

        return view('home.ingredients', compact('locations', 'ingredientsData'));
    }

}
