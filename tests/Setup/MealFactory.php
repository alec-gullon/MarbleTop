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

    public static function addMealWithOneItem($user)
    {
        $meal = self::addMeal($user);

        $item = ItemFactory::addItem($user);

        $meal->items()->attach($item, ['amount' => 1, 'preciseAmount' => '100g', 'order' => 1]);

        return $meal;
    }

    public static function addMealWithTwoItems($user)
    {
        $meal = self::addMeal($user);

        $items = ItemFactory::addTwoItems($user);

        $meal->items()->attach($items[0], ['amount' => 1, 'preciseAmount' => '100g', 'order' => 1]);
        $meal->items()->attach($items[1], ['amount' => 1.5, 'preciseAmount' => '200g', 'order' => 2]);

        return $meal;
    }
}
