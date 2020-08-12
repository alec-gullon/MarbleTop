<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_it_displays_a_users_items()
    {
        $user = factory('App\User')->create();

        $user->addItem([
            'name' => 'Red Onion',
            'location_id' => 1
        ]);

        $this->actingAs($user);

        $this->get(route('items'))
            ->assertSee('Red Onion');
    }
}
