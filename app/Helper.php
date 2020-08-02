<?php

namespace App;

use App\Models\Ingredient;
use App\Models\IngredientLocation;

use Illuminate\Support\Facades\Auth;

class Helper {

    public static function ingredientsData($user) {
        $user->refresh();
        $ingredients = $user->ingredients->sortBy('name');

        $ingredientsData = [];
        foreach ($ingredients as $ingredient) {
            $ingredientData = [
                'id' => $ingredient->id,
                'name' => $ingredient->name,
                'locationId' => $ingredient->location->id
            ];
            $ingredientsData[] = $ingredientData;
        }

        return $ingredientsData;
    }

    public static function mealsData($user) {
        $user->refresh();
        $meals = $user->meals->sortBy('name');

        $data = [];
        foreach ($meals as $meal) {
            $datum = [
                'id' => $meal->id,
                'name' => $meal->name
            ];
            $data[] = $datum;
        }
        return $data;
    }

    public static function groupsData($user) {
        $user->refresh();
        $groups = $user->groups->sortBy('name');

        $data = [];
        foreach ($groups as $group) {
            $datum = [
                'id' => $group->id,
                'name' => $group->name
            ];
            $data[] = $datum;
        }
        return $data;
    }

    public static function locationsData() {
        $ingredientLocations = IngredientLocation::all();

        $data = [];
        foreach ($ingredientLocations as $location) {
            $datum = [
                'id' => $location->id,
                'name' => $location->name
            ];
            $data[] = $datum;
        }

        return $data;

    }

    public static function plansData($user) {
        $user->refresh();
        $plans = $user->plans->sortByDesc('created_at');

        $data = [];
        foreach ($plans as $plan) {
            $datum = [
                'id' => $plan->id,
                'created_at' => $plan->created_at
            ];
            $data[] = $datum;
        }
        return $data;
    }

}
