<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_meals_homepage_displays_a_users_meals()
    {
        $user = factory('App\User')->create();
        $otherUser = factory('App\User')->create();

        $user->addMeal('Spaghetti Bolognese', 'My example recipe!');
        $otherUser->addMeal('Lemon Drizzle Cake', 'Other user example recipe');

        $this->actingAs($user);

        $this->get(route('meals'))
            ->assertSee('Spaghetti Bolognese')
            ->assertDontSee('Lemon Drizzle Cake');
    }

    public function test_groups_homepage_displays_a_users_groups()
    {
        $user = factory('App\User')->create();
        $otherUser = factory('App\User')->create();

        $user->addGroup('Kitchen Essentials');
        $otherUser->addGroup('Family Visit');

        $this->actingAs($user);

        $this->get(route('groups'))
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