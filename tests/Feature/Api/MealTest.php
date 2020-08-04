<?php

namespace Tests\Feature\Api;

use Tests\Setup\MealFactory;
use Tests\Setup\ItemFactory;
use Tests\Setup\UserFactory;

use App\Models\Meal;
use App\Models\Item;

use Tests\ApiTestCase;

class MealTest extends ApiTestCase
{
    public function test_a_user_can_create_a_meal()
    {


        $items = ItemFactory::addTwoItems($this->user);

        $attributes = [
            'name' => 'Spaghetti Bolognese',
            'recipe' => 'Lorem ipsum',
            'items' => [
                ['id' => $items[0]->id, 'amount' => 1.5, 'preciseAmount' => '100g', 'order' => 1],
                ['id' => $items[1]->id, 'amount' => 2.5, 'preciseAmount' => '200g', 'order' => 2]
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi(route('store-meal'), $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseHas('meals', [
            'user_id' => $this->user->id,
            'name' => $attributes['name'],
            'recipe' => $attributes['recipe']
        ]);

        $this->assertDatabaseHas('item_meal', [
            'item_id' => $items[0]->id,
            'meal_id' => Meal::first()->id,
            'amount' => $attributes['items'][0]['amount'],
            'preciseAmount' => $attributes['items'][0]['preciseAmount'],
            'order' => $attributes['items'][0]['order']
        ]);
    }

    public function test_a_user_cannot_create_a_meal_twice()
    {


        $meal = MealFactory::addMeal($this->user);

        $response = $this->callApi(route('store-meal'), [
            'name' => $meal->name,
            'recipe' => $meal->recipe,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'mealAlreadyExists');
    }

    public function test_adding_a_meal_requires_attributes()
    {
        $this->callApi(route('store-meal'), ['name' => ''], true)
            ->assertStatus(302);

        $this->callApi(route('store-meal'), ['name' => 'Spaghetti Bolognese', 'recipe' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Spaghetti Bolognese', 'recipe' => 'A recipe', 'items' => 'Bad item request'];

        $this->callApi(route('store-meal'), $attributes, true)->assertStatus(302);
    }

    public function test_a_user_can_update_a_meal()
    {
        $meal = MealFactory::addMealWithOneItem($this->user);
        $oldItem = Item::first();
        $newItem = ItemFactory::addItem($this->user);

        $attributes = [
            'name' => 'Updated Meal Name',
            'recipe' => 'Lorem ipsum updated',
            'items' => [
                ['id' => $newItem->id, 'amount' => 3, 'preciseAmount' => '50g', 'order' => 1],
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi($meal->apiPath() . 'update/', $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);
        $this->assertDatabaseHas('item_meal', [
            'item_id' => $newItem->id,
            'meal_id' => $meal->id,
            'amount' => $attributes['items'][0]['amount'],
            'preciseAmount' => $attributes['items'][0]['preciseAmount'],
            'order' => $attributes['items'][0]['order']
        ]);
        $this->assertDatabaseMissing('item_meal', [
            'item_id' => $oldItem->id,
            'meal_id' => $meal->id
        ]);
    }

    public function test_a_user_cannot_update_a_meal_to_have_the_same_name_as_another_meal()
    {


        $meal = MealFactory::addMeal($this->user);
        $secondaryMeal = MealFactory::addMeal($this->user);

        $response = $this->callApi($meal->apiPath() . 'update/', [
            'name' => $secondaryMeal->name,
            'recipe' => $meal->recipe,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'mealAlreadyExists');
    }

    public function test_updating_a_meal_requires_attributes()
    {
        $meal = MealFactory::addMeal($this->user);

        $path = route('update-meal', ['meal' => $meal->id]);

        $this->callApi($path, ['name' => ''], true)
            ->assertStatus(302);

        $this->callApi($path, ['name' => 'Spaghetti Bolognese', 'recipe' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Spaghetti Bolognese', 'recipe' => 'A recipe', 'items' => 'Bad item request'];

        $this->callApi($path, $attributes, true)->assertStatus(302);
    }

    public function test_a_user_cannot_update_another_users_meal()
    {
        $secondaryUser = UserFactory::addUser();
        $meal = MealFactory::addMeal($secondaryUser);

        $this->callApi(route('update-meal', ['meal' => $meal->id]), [
            'name' => 'A name',
            'recipe' => 'A recipe',
            'items' => json_encode([])
        ], true)->assertStatus(403);
    }

    public function test_a_user_can_delete_a_meal()
    {
        $meal = MealFactory::addMealWithTwoItems($this->user);

        $response = $this->callApi(route('destroy-meal', ['meal' => $meal->id]), [], true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseCount('item_meal', 0);
        $this->assertDatabaseCount('meals', 0);
        $this->assertDatabaseCount('items', 2);
    }

    public function test_a_user_cannot_delete_another_users_meal()
    {
        $secondaryUser = UserFactory::addUser();
        $meal = MealFactory::addMeal($secondaryUser);

        $this->callApi(route('destroy-meal', ['meal' => $meal->id]), [], true)
            ->assertStatus(403);
    }

}
