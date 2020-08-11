<?php

namespace Tests\Feature\Api;

use App\Models\Group;
use App\Models\Item;
use Tests\ApiTestCase;
use Tests\Setup\GroupFactory;
use Tests\Setup\ItemFactory;
use Tests\Setup\UserFactory;

class GroupTest extends ApiTestCase
{
    public function test_a_user_can_create_a_group()
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

        $response = $this->callApi(route('store-group'), $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseHas('groups', [
            'user_id' => $this->user->id,
            'name' => $attributes['name']
        ]);

        $this->assertDatabaseHas('group_item', [
            'item_id' => $items[0]->id,
            'group_id' => Group::first()->id,
            'amount' => $attributes['items'][0]['amount']
        ]);
    }

    public function test_a_user_cannot_create_a_group_twice()
    {
        $group = GroupFactory::addGroup($this->user);

        $response = $this->callApi(route('store-group'), [
            'name' => $group->name,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'groupAlreadyExists');
    }

    public function test_adding_a_group_requires_attributes()
    {
        $this->callApi(route('store-group'), ['name' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Infrequent Items', 'items' => 'Bad item request'];

        $this->callApi(route('store-group'), $attributes, true)->assertStatus(302);
    }

    public function test_a_user_can_update_a_group()
    {
        $group = GroupFactory::addGroupWithOneItem($this->user);
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

        $response = $this->callApi(route('update-group', ['group' => $group->id]), $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);
        $this->assertDatabaseHas('group_item', [
            'item_id' => $newItem->id,
            'group_id' => $group->id,
            'amount' => $attributes['items'][0]['amount']
        ]);
        $this->assertDatabaseMissing('group_item', [
            'item_id' => $oldItem->id,
            'group_id' => $group->id
        ]);
    }

    public function test_a_user_cannot_update_a_group_to_have_the_same_name_as_another_group()
    {
        $group = GroupFactory::addGroup($this->user);
        $secondaryGroup = GroupFactory::addGroup($this->user);

        $response = $this->callApi(route('update-group', ['group' => $group->id]), [
            'name' => $secondaryGroup->name,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'groupAlreadyExists');
    }

    public function test_updating_a_group_requires_attributes()
    {
        $group = GroupFactory::addGroup($this->user);

        $path = route('update-group', ['group' => $group->id]);

        $this->callApi($path, ['name' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Infrequent Items', 'items' => 'Bad items request'];

        $this->callApi($path, $attributes, true)
            ->assertStatus(302);
    }

    public function test_a_user_cannot_update_another_users_group()
    {
        $secondaryUser = UserFactory::addUser();
        $group = GroupFactory::addGroup($secondaryUser);

        $this->callApi(route('update-group', ['group' => $group->id]), [
            'name' => 'A name',
            'items' => json_encode([])
        ], true)->assertStatus(403);
    }

    public function test_a_user_can_delete_a_group()
    {
        $group = GroupFactory::addGroupWithTwoItems($this->user);

        $response = $this->callApi(route('destroy-group', ['group' => $group->id]), [], true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseCount('group_item', 0);
        $this->assertDatabaseCount('groups', 0);
        $this->assertDatabaseCount('items', 2);
    }

    public function test_a_user_cannot_delete_another_users_groups()
    {
        $secondaryUser = UserFactory::addUser();
        $group = GroupFactory::addGroup($secondaryUser);

        $this->callApi(route('destroy-group', ['group' => $group->id]), [], true)
            ->assertStatus(403);
    }
}
