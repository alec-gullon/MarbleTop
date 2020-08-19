<?php

namespace Tests\Feature;

use App\Models\Item;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\ItemFactory;
use Tests\Setup\CollectionFactory;

use Tests\TestCase;

class CollectionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_collection_index_displays_a_users_collections()
    {
        $user = $this->signIn();
        $collection = CollectionFactory::addCollection($user);

        $this->get(route('collections'))
            ->assertSee($collection->name);
    }

    public function test_add_collection_form_pulls_in_user_items()
    {
        $user = $this->signIn();
        $items = ItemFactory::addTwoItems($user);

        $this->get(route('collections-add'))
            ->assertSee($items[0]->name)
            ->assertSee($items[1]->name);
    }

    public function test_editing_a_collection_displays_the_items()
    {
        $user = $this->signIn();
        $collection = CollectionFactory::addCollectionWithTwoItems($user);
        $items = Item::all();

        $this->get(route('collections-edit', ['collection' => $collection->id]))
            ->assertSee($items[0]->name)
            ->assertSee($items[1]->name);
    }
}
