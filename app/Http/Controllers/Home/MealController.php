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

        return view('home.create-meal', compact('itemsData'));
    }

    public function meal(Meal $meal)
    {
        $itemsData = [];

        foreach ($meal->items as $item) {
            $itemsData[$item->pivot->order] = [
                'name' => $item->name,
                'amount' => $item->pivot->preciseAmount
            ];
        }

        return view('home.recipe', compact('meal', 'itemsData'));
    }

    public function edit(Meal $meal)
    {
        $itemsData = Helper::itemsData(auth()->user());
        foreach ($itemsData as $key => $item) {
            $data = $item;

            $selected = false;
            $amount = 1;
            $order = -1;
            $preciseAmount = '';

            foreach ($meal->items as $mealItem) {
                if ($mealItem->id === $item['id']) {
                    $selected = true;
                    $amount = (float) $mealItem->pivot->amount;
                    $order = (int) $mealItem->pivot->order;
                    $preciseAmount = $mealItem->pivot->preciseAmount;
                }
            }

            $data['key'] = $key;
            $data['selected'] = $selected;
            $data['amount'] = $amount;
            $data['preciseAmount'] = $preciseAmount;
            $data['order'] = $order;

            $itemsData[$key] = $data;
        }

        return view('home.edit-meal', compact('meal', 'itemsData'));
    }
}
