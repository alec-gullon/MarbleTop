<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $user;

    private $secondaryUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
        $this->secondaryUser = factory('App\User')->create();
    }

    public function callApi($path, $arguments, $returnResponse = false)
    {
        $arguments = array_merge($arguments, ['api_token' => $this->user->api_token]);

        $response = $this->post($path, $arguments);

        if ($returnResponse) {
             return $response;
        }

        return json_decode($response->getContent());
    }

    public function ingredientAttributes($overrides = [])
    {
        $default = [
            'name' => 'Red Onion',
            'location_id' => 1
        ];

        foreach ($overrides as $key => $value) {
            $default[$key] = $value;
        }

        return $default;
    }

    public function test_a_user_can_add_an_ingredient()
    {
        $attributes = $this->ingredientAttributes();

        $response = $this->callApi(
            route('add-ingredient'),
            $attributes
        );

        $this->assertEquals($response->status, 200);
        $this->assertEquals($response->ingredients[0]->name, 'Red Onion');

        $attributes['user_id'] = [$this->user->id];
        $this->assertDatabaseHas('ingredients', $attributes);
    }

    public function test_a_user_cannot_add_an_ingredient_that_already_exists()
    {
        $attributes = $this->ingredientAttributes();

        $this->user->addIngredient($attributes);

        $response = $this->callApi(route('add-ingredient'), $attributes);

        $this->assertEquals(400, $response->status);
        $this->assertEquals('ingredientAlreadyExists', $response->error);
    }

    public function test_adding_an_ingredient_requires_the_name()
    {
        $attributes = $this->ingredientAttributes(['name' => '']);

        $this->callApi(route('add-ingredient'), $attributes, true)
            ->assertStatus(302);
    }

    public function test_adding_an_ingredient_requires_a_valid_location_id()
    {
        $attributes = $this->ingredientAttributes(
            ['location_id' => 10]
        );

        $this->callApi(route('add-ingredient'), $attributes, true)
            ->assertStatus(302);
    }

    public function test_a_user_can_update_an_ingredient()
    {
        $ingredient = $this->user->addIngredient($this->ingredientAttributes());

        $updatedAttributes = [
            'name' => 'Large Red Onion',
            'location_id' => 3
        ];

        $response = $this->callApi(
            $ingredient->apiPath() . 'update/',
            $updatedAttributes
        );

        $this->assertEquals($response->status, 200);
        $this->assertEquals(count($response->ingredients), 1);
        $this->assertEquals($response->ingredients[0]->name, 'Large Red Onion');

        $updatedAttributes['user_id'] = $this->user->id;
        $this->assertDatabaseHas('ingredients', $updatedAttributes);
    }

    public function test_updating_an_ingredient_returns_error_if_ingredient_already_exists()
    {
        $ingredient = $this->user->addIngredient($this->ingredientAttributes());

        $attributes = [
            'name' => 'White Onion',
            'location_id' => 1
        ];
        $this->user->addIngredient($attributes);

        $response = $this->callApi(
            $ingredient->apiPath() . 'update/',
            $attributes
        );

        $this->assertEquals(400, $response->status);
        $this->assertEquals('ingredientAlreadyExists', $response->error);
    }

    public function test_updating_an_ingredient_requires_the_name()
    {
        $ingredient = $this->user->addIngredient($this->ingredientAttributes());

        $this->callApi($ingredient->apiPath() . 'update/', ['name' => '', 'location_id' => 1], true)
            ->assertStatus(302);
    }

    public function test_updating_an_ingredient_requires_a_valid_location_id()
    {
        $ingredient = $this->user->addIngredient($this->ingredientAttributes());

        $attributes = $this->ingredientAttributes(['location_id' => 10]);

        $this->callApi($ingredient->apiPath() . 'update/', $attributes, true)
            ->assertStatus(302);
    }

    public function test_updating_an_ingredient_requires_a_valid_ingredient_id()
    {
        $this->user->addIngredient($this->ingredientAttributes());

        $this->callApi('/api/ingredients/100/update', [], true)
            ->assertStatus(404);
    }

    public function test_a_user_cannot_update_another_users_ingredients()
    {
        $ingredient = $this->secondaryUser->addIngredient($this->ingredientAttributes());

        $this->callApi($ingredient->apiPath() . 'update/', [
            'name' => 'My Red Onion!',
            'location_id' => 3
        ], true)->assertStatus(403);
    }

    public function test_a_user_can_delete_their_ingredients()
    {
        $attributes = $this->ingredientAttributes();
        $ingredient = $this->user->addIngredient($attributes);

        $response = $this->callApi($ingredient->apiPath() . 'remove/', []);

        $this->assertEquals($response->status, 200);
        $this->assertEquals(count($response->ingredients), 0);

        $attributes['user_id'] = $this->user->id;
        $this->assertDatabaseMissing('ingredients', $attributes);
    }

    public function test_a_user_cannot_delete_other_peoples_ingredients()
    {
        $attributes = $this->ingredientAttributes();

        $ingredient = $this->secondaryUser->addIngredient($attributes);

        $this->callApi($ingredient->apiPath() . 'remove/', [], true)
            ->assertStatus(403);

        $attributes['user_id'] = $this->secondaryUser->id;
        $this->assertDatabaseHas('ingredients', $attributes);
    }
}
