<?php

namespace Tests\Unit\Models;

use App\Models\Item;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\CollectionFactory;
use Tests\Setup\ItemFactory;
use Tests\TestCase;


class CollectionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_it_can_attach_items()
    {
        $user = factory('App\User')->create();
        $collection = CollectionFactory::addCollection($user);
        ItemFactory::addTwoItems($user);
        $items = Item::all();

        $collection->attachItems([
            [
                'id' => $items[0]->id,
                'amount' => 1,
            ],
            [
                'id' => $items[1]->id,
                'amount' => 2
            ]
        ]);

        $this->assertDatabaseHas('collection_item', [
            'item_id' => $items[0]->id,
            'amount' => 1,
            'collection_id' => $collection->id
        ]);
        $this->assertDatabaseHas('collection_item', [
            'item_id' => $items[1]->id,
            'amount' => 2,
            'collection_id' => $collection->id
        ]);
    }

}
