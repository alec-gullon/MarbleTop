<?php

namespace Tests\Feature\Home;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\ItemFactory;

use Tests\TestCase;

class ItemTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_it_displays_a_users_items()
    {
        $user = $this->signIn();
        $item = ItemFactory::addItem($user);

        $this->get(route('items'))
            ->assertSee($item->name);
    }

    public function test_it_displays_the_correct_location_selection()
    {
        $this->signIn();

        $this->get(route('items'))
            ->assertSee('Frozen');
    }
}
