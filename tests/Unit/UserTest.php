<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function test_a_user_can_add_a_meal()
    {
        $user = factory('App\User')->create();

        $name = 'Spaghetti Bolognese';
        $recipe = 'My example recipe';

        $meal = $user->addMeal(['name' => $name, 'recipe' => $recipe]);

        $this->assertCount(1, $user->meals);
        $this->assertTrue($user->meals->contains($meal));
        $this->assertDatabaseHas('meals', [
            'name' => $name,
            'recipe' => $recipe
        ]);
    }

    public function test_a_user_can_add_a_group()
    {
        $user = factory('App\User')->create();

        $name = 'Kitchen Essentials';

        $group = $user->addGroup($name);

        $this->assertCount(1, $user->groups);
        $this->assertTrue($user->groups->contains($group));
        $this->assertDatabaseHas('groups', [
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
