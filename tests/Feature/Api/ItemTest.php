<?php

namespace Tests\Feature\Api;

use Tests\ApiTestCase;

use Tests\Setup\ItemFactory;
use Tests\Setup\UserFactory;

use App\Models\Item;

class ItemTest extends ApiTestCase
{
    public function test_a_user_can_add_an_item()
    {
        $attributes = [
            'name' => 'Red Onion',
            'location_id' => 1,
            'user_id' => $this->user->id
        ];

        $response = $this->callApi(
            route('store-item'),
            $attributes
        );

        $this->assertEquals($response->status, 200);
        $this->assertEquals($response->items->{1}->name, $attributes['name']);
        $this->assertDatabaseHas('items', $attributes);
    }

    public function test_a_user_cannot_add_an_item_that_already_exists()
    {
        ItemFactory::addItem($this->user);

        $response = $this->callApi(route('store-item'), [
            'name' => Item::first()->name,
            'location_id' => 1
        ]);

        $this->assertEquals(400, $response->status);
        $this->assertEquals('itemAlreadyExists', $response->error);
    }

    public function test_adding_an_item_requires_the_name()
    {
        $this->callApi(route('store-item'), ['name' => ''], true)
            ->assertStatus(302);
    }

    public function test_adding_an_item_requires_a_valid_location_id()
    {
        $this->callApi(route('store-item'), ['name' => 'Red Onion', 'location_id' => 10], true)
            ->assertStatus(302);
    }

    public function test_a_user_can_update_an_item()
    {
        $item = ItemFactory::addItem($this->user);

        $attributes = [
            'name' => 'Large Red Onion',
            'location_id' => 3,
            'user_id' => $this->user->id
        ];

        $response = $this->callApi(
            $item->apiPath() . 'update/',
            $attributes
        );

        $this->assertEquals($response->status, 200);

        $response->items = (array) $response->items;

        $this->assertEquals(count((array) $response->items), 1);
        $this->assertEquals($response->items[1]->name, $attributes['name']);
        $this->assertDatabaseHas('items', $attributes);
    }

    public function test_updating_an_item_returns_error_if_item_already_exists()
    {
        ItemFactory::addTwoItems($this->user);

        $items = Item::all();
        $initialItem = $items[0];
        $secondaryItem = $items[1];

        $response = $this->callApi(
            $initialItem->apiPath() . 'update/',
            [
                'name' => $secondaryItem->name,
                'location_id' => 1
            ]
        );

        $this->assertEquals(400, $response->status);
        $this->assertEquals('itemAlreadyExists', $response->error);
    }

    public function test_updating_an_item_requires_a_valid_item_id()
    {
        $this->callApi(route('update-item', ['item' => 100]), [], true)
            ->assertStatus(404);
    }

    public function test_a_user_cannot_update_another_users_items()
    {
        $secondaryUser = UserFactory::addUser();
        $item = ItemFactory::addItem($secondaryUser);

        $this->callApi($item->apiPath() . 'update/', [], true)->assertStatus(403);
    }

    public function test_updating_an_item_requires_the_name()
    {
        $item = ItemFactory::addItem($this->user);

        $this->callApi($item->apiPath() . 'update/', ['name' => '', 'location_id' => 1], true)
            ->assertStatus(302);
    }

    public function test_updating_an_item_requires_a_valid_location_id()
    {
        $item = ItemFactory::addItem($this->user);

        $this->callApi($item->apiPath() . 'update/', ['name' => 'Red Onion', 'location_id' => 10], true)
            ->assertStatus(302);
    }

    public function test_a_user_can_delete_their_items()
    {
        $item = ItemFactory::addItem($this->user);

        $response = $this->callApi($item->apiPath() . 'destroy/');

        $this->assertEquals($response->status, 200);
        $this->assertEquals(count($response->items), 0);
        $this->assertDatabaseMissing('items', ['user_id' => $this->user->id]);
    }

    public function test_a_user_cannot_delete_other_peoples_items()
    {
        $secondaryUser = UserFactory::addUser();
        $item = ItemFactory::addItem($secondaryUser);

        $this->callApi($item->apiPath() . 'destroy/', [], true)
            ->assertStatus(403);

        $this->assertDatabaseHas('items', ['user_id' => $secondaryUser->id]);
    }
}
