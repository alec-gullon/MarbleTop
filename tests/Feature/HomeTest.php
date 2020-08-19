<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class HomeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_recipes_homepage_displays_a_users_recipes()
    {
        $user = factory('App\User')->create();
        $otherUser = factory('App\User')->create();

        $user->addRecipe(['name' => 'Spaghetti Bolognese', 'recipe' => 'My example recipe!']);
        $otherUser->addRecipe(['name' => 'Lemon Drizzle Cake', 'recipe' => 'Other user example recipe']);

        $this->actingAs($user);

        $this->get(route('recipes'))
            ->assertSee('Spaghetti Bolognese')
            ->assertDontSee('Lemon Drizzle Cake');
    }

    public function test_collections_homepage_displays_a_users_collections()
    {
        $user = factory('App\User')->create();
        $otherUser = factory('App\User')->create();

        $user->addCollection(['name' => 'Kitchen Essentials']);
        $otherUser->addCollection(['name' => 'Family Visit']);

        $this->actingAs($user);

        $this->get(route('collections'))
            ->assertSee('Kitchen Essentials')
            ->assertDontSee('Family Visit');
    }

    public function test_plans_homepage_displays_a_users_plans()
    {
        $user = factory('App\User')->create();
        $otherUser = factory('App\User')->create();

        $user->addPlan();
        $user->addPlan();

        $otherUser->addPlan();

        $this->actingAs($user);

        $this->get(route('plans'))
            ->assertSee('data-test="2"')
            ->assertDontSee('data-test="1"');
    }
}
