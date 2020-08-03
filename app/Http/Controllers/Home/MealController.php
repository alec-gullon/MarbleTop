<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\Meal;
use App\Helper;

class MealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $meals = \App\Helper::mealsData(auth()->user());

        return view('home.meals', compact('meals'));
    }

    public function add()
    {
        $ingredientsData = Helper::ingredientsData(auth()->user());
        foreach ($ingredientsData as $key => $ingredient) {
            $data = $ingredient;

            $data['key'] = $key;
            $data['selected'] = false;
            $data['amount'] = 1;
            $data['preciseAmount'] = '100g';
            $data['order'] = 0;

            $ingredientsData[$key] = $data;
        }

        return view('home.create-meal', compact('ingredientsData'));
    }

    public function meal(Meal $meal)
    {
        $ingredientsData = [];

        foreach ($meal->ingredients as $ingredient) {
            $ingredientsData[$ingredient->pivot->order] = [
                'name' => $ingredient->name,
                'amount' => $ingredient->pivot->preciseAmount
            ];
        }

        return view('home.recipe', compact('meal', 'ingredientsData'));
    }

    public function edit(Meal $meal)
    {
        $ingredientsData = Helper::ingredientsData(auth()->user());
        foreach ($ingredientsData as $key => $ingredient) {
            $data = $ingredient;

            $selected = false;
            $amount = 1;
            $order = -1;
            $preciseAmount = '';

            foreach ($meal->ingredients as $mealIngredient) {
                if ($mealIngredient->id === $ingredient['id']) {
                    $selected = true;
                    $amount = (float) $mealIngredient->pivot->amount;
                    $order = (int) $mealIngredient->pivot->order;
                    $preciseAmount = $mealIngredient->pivot->preciseAmount;
                }
            }

            $data['key'] = $key;
            $data['selected'] = $selected;
            $data['amount'] = $amount;
            $data['preciseAmount'] = $preciseAmount;
            $data['order'] = $order;

            $ingredientsData[$key] = $data;
        }

        return view('home.edit-meal', compact('meal', 'ingredientsData'));
    }
}
