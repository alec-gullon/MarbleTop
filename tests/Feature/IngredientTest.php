<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_it_displays_a_users_ingredients()
    {
        $user = factory('App\User')->create();

        $user->addIngredient([
            'name' => 'Red Onion',
            'location_id' => 1
        ]);

        $this->actingAs($user);

        $this->get(route('ingredients'))
            ->assertSee('Red Onion');
    }
}
