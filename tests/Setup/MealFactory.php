<?php

namespace Tests\Setup;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MealFactory
{
    public static function addMeal($user)
    {
        return $user->addMeal(['name' => Str::random(16), 'recipe' => 'Lorem Ipsum']);
    }

    public static function addMealWithOneIngredient($user)
    {
        $meal = self::addMeal($user);

        $ingredient = IngredientFactory::addIngredient($user);

        $meal->ingredients()->attach($ingredient, ['amount' => 1, 'preciseAmount' => '100g', 'order' => 1]);

        return $meal;
    }

    public static function addMealWithTwoIngredients($user)
    {
        $meal = self::addMeal($user);

        $ingredients = IngredientFactory::addTwoIngredients($user);

        $meal->ingredients()->attach($ingredients[0], ['amount' => 1, 'preciseAmount' => '100g', 'order' => 1]);
        $meal->ingredients()->attach($ingredients[1], ['amount' => 1.5, 'preciseAmount' => '200g', 'order' => 2]);

        return $meal;
    }
}
