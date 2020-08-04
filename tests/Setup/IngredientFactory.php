<?php

namespace Tests\Setup;

use App\Models\Ingredient;

class IngredientFactory
{
    public static function addIngredient($user)
    {
        return $user->addIngredient([
            'name' => 'Red Onion',
            'location_id' => 1
        ]);
    }

    public static function addTwoIngredients($user)
    {
        $user->addIngredient([
            'name' => 'Red Onion',
            'location_id' => 1
        ]);

        $user->addIngredient([
            'name' => 'White Onion',
            'location_id' => 1
        ]);

        return Ingredient::all();
    }
}
