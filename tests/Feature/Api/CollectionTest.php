<?php

namespace Tests\Feature\Api;

use App\Models\Collection;
use App\Models\Item;

use Tests\ApiTestCase;

use Tests\Setup\CollectionFactory;
use Tests\Setup\ItemFactory;
use Tests\Setup\UserFactory;

class CollectionTest extends ApiTestCase
{
    public function test_a_user_can_create_a_collection()
    {
        $items = ItemFactory::addTwoItems($this->user);

        $attributes = [
            'name' => 'Infrequent Items',
            'items' => [
                ['id' => $items[0]->id, 'amount' => 1.5],
                ['id' => $items[1]->id, 'amount' => 2.5]
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi(route('store-collection'), $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseHas('collections', [
            'user_id' => $this->user->id,
            'name' => $attributes['name']
        ]);

        $this->assertDatabaseHas('collection_item', [
            'item_id' => $items[0]->id,
            'collection_id' => Collection::first()->id,
            'amount' => $attributes['items'][0]['amount']
        ]);
    }

    public function test_a_user_cannot_create_a_collection_twice()
    {
        $collection = CollectionFactory::addCollection($this->user);

        $response = $this->callApi(route('store-collection'), [
            'name' => $collection->name,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'collectionAlreadyExists');
    }

    public function test_adding_a_collection_requires_attributes()
    {
        $this->callApi(route('store-collection'), ['name' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Infrequent Items', 'items' => 'Bad item request'];

        $this->callApi(route('store-collection'), $attributes, true)->assertStatus(302);
    }

    public function test_a_user_can_update_a_collection()
    {
        $collection = CollectionFactory::addCollectionWithOneItem($this->user);
        $oldItem = Item::first();
        $newItem = ItemFactory::addItem($this->user);

        $attributes = [
            'name' => 'Infrequent Items Updated',
            'items' => [
                ['id' => $newItem->id, 'amount' => 3],
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi(route('update-collection', ['collection' => $collection->id]), $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);
        $this->assertDatabaseHas('collection_item', [
            'item_id' => $newItem->id,
            'collection_id' => $collection->id,
            'amount' => $attributes['items'][0]['amount']
        ]);
        $this->assertDatabaseMissing('collection_item', [
            'item_id' => $oldItem->id,
            'collection_id' => $collection->id
        ]);
    }

    public function test_a_user_cannot_update_a_collection_to_have_the_same_name_as_another_collection()
    {
        $collection = CollectionFactory::addCollection($this->user);
        $secondaryCollection = CollectionFactory::addCollection($this->user);

        $response = $this->callApi(route('update-collection', ['collection' => $collection->id]), [
            'name' => $secondaryCollection->name,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'collectionAlreadyExists');
    }

    public function test_updating_a_collection_requires_attributes()
    {
        $collection = CollectionFactory::addCollection($this->user);

        $path = route('update-collection', ['collection' => $collection->id]);

        $this->callApi($path, ['name' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Infrequent Items', 'items' => 'Bad items request'];

        $this->callApi($path, $attributes, true)
            ->assertStatus(302);
    }

    public function test_a_user_cannot_update_another_users_collection()
    {
        $secondaryUser = UserFactory::addUser();
        $collection = CollectionFactory::addCollection($secondaryUser);

        $this->callApi(route('update-collection', ['collection' => $collection->id]), [
            'name' => 'A name',
            'items' => json_encode([])
        ], true)->assertStatus(403);
    }

    public function test_a_user_can_delete_a_collection()
    {
        $collection = CollectionFactory::addCollectionWithTwoItems($this->user);

        $response = $this->callApi(route('destroy-collection', ['collection' => $collection->id]), [], true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseCount('collection_item', 0);
        $this->assertDatabaseCount('collections', 0);
        $this->assertDatabaseCount('items', 2);
    }

    public function test_a_user_cannot_delete_another_users_collections()
    {
        $secondaryUser = UserFactory::addUser();
        $collection = CollectionFactory::addCollection($secondaryUser);

        $this->callApi(route('destroy-collection', ['collection' => $collection->id]), [], true)
            ->assertStatus(403);
    }
}
