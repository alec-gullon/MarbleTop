<?php

namespace Tests\Setup;

use Illuminate\Support\Str;

class RecipeFactory
{
    public static function addRecipe($user)
    {
        return $user->addRecipe([
            'name' => Str::random(16),
            'recipe' => 'Lorem Ipsum',
            'description' => 'Happy Description',
            'cook_time' => 20,
            'serving_size' => 4,
        ]);
    }

    public static function addRecipeWithName($user, $name)
    {
        return $user->addRecipe(['name' => $name, 'recipe' => 'Lorem Ipsum']);
    }

    public static function addPublishedRecipe($user)
    {
        return $user->addRecipe([
            'name' => Str::random(16),
            'slug' => 'an-example-slug',
            'recipe' => 'Lorem Ipsum',
            'description' => 'Happy Description',
            'cook_time' => 20,
            'serving_size' => 4,
            'published' => true
        ]);
    }

    public static function addRecipeWithOneItem($user)
    {
        $recipe = self::addRecipe($user);

        $item = ItemFactory::addItem($user);

        $recipe->items()->attach($item, ['amount' => 1, 'precise_amount' => '100g', 'order' => 1]);

        return $recipe;
    }

    public static function addRecipeWithTwoItems($user)
    {
        $recipe = self::addRecipe($user);

        $items = ItemFactory::addTwoItems($user);

        $recipe->items()->attach($items[0], ['amount' => 1, 'precise_amount' => '100g', 'order' => 1]);
        $recipe->items()->attach($items[1], ['amount' => 1.5, 'precise_amount' => '200g', 'order' => 2]);

        return $recipe;
    }
}
