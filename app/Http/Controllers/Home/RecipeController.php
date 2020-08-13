<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\Recipe;
use App\Helper;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $recipes = \App\Helper::recipesData(auth()->user());

        return view('home.recipes.index', compact('recipes'));
    }

    public function add()
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $data['key'] = $key;
            $data['selected'] = false;
            $data['amount'] = 1;
            $data['preciseAmount'] = '100g';
            $data['order'] = 0;

            $itemsData[$key] = $data;
        }

        return view('home.recipes.create-recipe', compact('itemsData'));
    }

    public function recipe(Recipe $recipe)
    {
        $primaryItemsData = [];
        $secondaryItemsData = [];

        foreach ($recipe->items as $item) {
            if (!empty($item->pivot->precise_amount)) {
                $primaryItemsData[] = [
                    'name' => $item->name,
                    'amount' => $item->pivot->precise_amount
                ];
            } else {
                $secondaryItemsData[] = [
                    'name' => $item->name
                ];
            }
        }



        return view('home.recipes.recipe', compact('recipe', 'primaryItemsData', 'secondaryItemsData'));
    }

    public function edit(Recipe $recipe)
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $selected = false;
            $amount = 1;
            $order = -1;
            $precise_amount = '';

            foreach ($recipe->items as $recipeItem) {
                if ($recipeItem->id === $item['id']) {
                    $selected = true;
                    $amount = (float) $recipeItem->pivot->amount;
                    $order = (int) $recipeItem->pivot->order;
                    $precise_amount = $recipeItem->pivot->precise_amount;
                }
            }

            $data['key'] = $key;
            $data['selected'] = $selected;
            $data['amount'] = $amount;
            $data['preciseAmount'] = $precise_amount;
            $data['order'] = $order;

            $itemsData[$key] = $data;
        }

        return view('home.recipes.edit-recipe', compact('recipe', 'itemsData'));
    }
}
