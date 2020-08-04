<?php

namespace Tests\Feature\Api;

use Tests\Setup\IngredientFactory;
use Tests\Setup\UserFactory;

use App\Models\Ingredient;

class IngredientTest extends ApiTestCase
{
    public function test_a_user_can_add_an_ingredient()
    {
        $attributes = [
            'name' => 'Red Onion',
            'location_id' => 1,
            'user_id' => $this->user->id
        ];

        $response = $this->callApi(
            route('store-ingredient'),
            $attributes
        );

        $this->assertEquals($response->status, 200);
        $this->assertEquals($response->ingredients[0]->name, $attributes['name']);
        $this->assertDatabaseHas('ingredients', $attributes);
    }

    public function test_a_user_cannot_add_an_ingredient_that_already_exists()
    {
        IngredientFactory::addIngredient($this->user);

        $response = $this->callApi(route('store-ingredient'), [
            'name' => Ingredient::first()->name,
            'location_id' => 1
        ]);

        $this->assertEquals(400, $response->status);
        $this->assertEquals('ingredientAlreadyExists', $response->error);
    }

    public function test_adding_an_ingredient_requires_the_name()
    {
        $this->callApi(route('store-ingredient'), ['name' => ''], true)
            ->assertStatus(302);
    }

    public function test_adding_an_ingredient_requires_a_valid_location_id()
    {
        $this->callApi(route('store-ingredient'), ['name' => 'Red Onion', 'location_id' => 10], true)
            ->assertStatus(302);
    }

    public function test_a_user_can_update_an_ingredient()
    {
        $ingredient = IngredientFactory::addIngredient($this->user);

        $attributes = [
            'name' => 'Large Red Onion',
            'location_id' => 3,
            'user_id' => $this->user->id
        ];

        $response = $this->callApi(
            $ingredient->apiPath() . 'update/',
            $attributes
        );

        $this->assertEquals($response->status, 200);
        $this->assertEquals(count($response->ingredients), 1);
        $this->assertEquals($response->ingredients[0]->name, $attributes['name']);
        $this->assertDatabaseHas('ingredients', $attributes);
    }

    public function test_updating_an_ingredient_returns_error_if_ingredient_already_exists()
    {
        IngredientFactory::addTwoIngredients($this->user);

        $ingredients = Ingredient::all();
        $initialIngredient = $ingredients[0];
        $secondaryIngredient = $ingredients[1];

        $response = $this->callApi(
            $initialIngredient->apiPath() . 'update/',
            [
                'name' => $secondaryIngredient->name,
                'location_id' => 1
            ]
        );

        $this->assertEquals(400, $response->status);
        $this->assertEquals('ingredientAlreadyExists', $response->error);
    }

    public function test_updating_an_ingredient_requires_a_valid_ingredient_id()
    {
        $this->callApi(route('update-ingredient', ['ingredient' => 100]), [], true)
            ->assertStatus(404);
    }

    public function test_a_user_cannot_update_another_users_ingredients()
    {
        $secondaryUser = UserFactory::addUser();
        $ingredient = IngredientFactory::addIngredient($secondaryUser);

        $this->callApi($ingredient->apiPath() . 'update/', [], true)->assertStatus(403);
    }

    public function test_updating_an_ingredient_requires_the_name()
    {
        $ingredient = IngredientFactory::addIngredient($this->user);

        $this->callApi($ingredient->apiPath() . 'update/', ['name' => '', 'location_id' => 1], true)
            ->assertStatus(302);
    }

    public function test_updating_an_ingredient_requires_a_valid_location_id()
    {
        $ingredient = IngredientFactory::addIngredient($this->user);

        $this->callApi($ingredient->apiPath() . 'update/', ['name' => 'Red Onion', 'location_id' => 10], true)
            ->assertStatus(302);
    }

    public function test_a_user_can_delete_their_ingredients()
    {
        $ingredient = IngredientFactory::addIngredient($this->user);

        $response = $this->callApi($ingredient->apiPath() . 'destroy/');

        $this->assertEquals($response->status, 200);
        $this->assertEquals(count($response->ingredients), 0);
        $this->assertDatabaseMissing('ingredients', ['user_id' => $this->user->id]);
    }

    public function test_a_user_cannot_delete_other_peoples_ingredients()
    {
        $secondaryUser = UserFactory::addUser();
        $ingredient = IngredientFactory::addIngredient($secondaryUser);

        $this->callApi($ingredient->apiPath() . 'destroy/', [], true)
            ->assertStatus(403);

        $this->assertDatabaseHas('ingredients', ['user_id' => $secondaryUser->id]);
    }
}
