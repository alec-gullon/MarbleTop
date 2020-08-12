<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_a_user_can_add_a_recipe()
    {
        $user = factory('App\User')->create();

        $name = 'Spaghetti Bolognese';
        $recipeText = 'My example recipe';

        $recipe = $user->addRecipe(['name' => $name, 'recipe' => $recipeText]);

        $this->assertCount(1, $user->recipes);
        $this->assertTrue($user->recipes->contains($recipe));
        $this->assertDatabaseHas('recipes', [
            'name' => $name,
            'recipe' => $recipeText
        ]);
    }

    public function test_a_user_can_add_a_collection()
    {
        $user = factory('App\User')->create();

        $name = 'Kitchen Essentials';

        $collection = $user->addCollection(['name' => $name]);

        $this->assertCount(1, $user->collections);
        $this->assertTrue($user->collections->contains($collection));
        $this->assertDatabaseHas('collections', [
            'name' => $name,
        ]);
    }

    public function test_a_user_can_add_a_plan()
    {
        $user = factory('App\User')->create();

        $plan = $user->addPlan();

        $this->assertCount(1, $user->plans);
        $this->assertTrue($user->plans->contains($plan));
        $this->assertDatabaseHas('plans', [
            'created_at' => $plan->created_at,
        ]);
    }
}
