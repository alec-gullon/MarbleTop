<?php

namespace App\Vue;

use App\Models\ItemLocation;
use Illuminate\Support\Facades\Auth;

class PlanCreator
{
    public static function locations()
    {
        $locations = ItemLocation::all();

        $data = [];
        foreach ($locations as $location) {
            $data[$location->id] = [
                'id' => $location->id,
                'name' => $location->name,
                'expanded' => false
            ];
        }

        return $data;
    }

    public static function items()
    {
        $data = [];
        foreach (Auth::user()->items as $item) {
            $data[$item->id] = [
                'name' => $item->name,
                'locationId' => $item->location_id
            ];
        }

        return $data;
    }

    public static function recipes()
    {
        $user = Auth::user();

        $recipes = [];

        foreach ($user->recipes as $recipeModel) {
            $recipe = [
                'id' => 'recipe-' . $recipeModel->id,
                'name' => $recipeModel->name
            ];

            $data = [];
            foreach ($recipeModel->items as $item) {
                $data[$item->id] = [
                    'amount' => (float) $item->pivot->amount,
                    'id' => $item->id
                ];
            }

            $recipe['items'] = $data;
            $recipes['recipe-' . $recipeModel->id] = $recipe;
        }

        foreach ($user->collections as $collectionModel) {
            $collection = [
                'id' => 'collection-' . $collectionModel->id,
                'name' => $collectionModel->name
            ];

            $data = [];
            foreach ($collectionModel->items as $item) {
                $data[$item->id] = [
                    'amount' => (float) $item->pivot->amount,
                    'id' => $item->id
                ];
            }

            $collection['items'] = $data;
            $recipes['collection-' . $collectionModel->id] = $collection;
        }

        usort($recipes, function($a, $b) {
            return $b['name'] < $a['name'];
        });

        return $recipes;
    }
}
