<?php

namespace Tests\Feature\Api;

use Tests\Setup\RecipeFactory;
use Tests\Setup\ItemFactory;
use Tests\Setup\UserFactory;

use App\Models\Recipe;
use App\Models\Item;

use Tests\ApiTestCase;

class RecipeTest extends ApiTestCase
{
    public function test_a_user_can_create_a_recipe()
    {
        $items = ItemFactory::addTwoItems($this->user);

        $attributes = [
            'name' => 'Spaghetti Bolognese',
            'recipe' => 'Lorem ipsum',
            'items' => [
                ['id' => $items[0]->id, 'amount' => 1.5, 'precise_amount' => '100g', 'order' => 1],
                ['id' => $items[1]->id, 'amount' => 2.5, 'precise_amount' => '200g', 'order' => 2]
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi(route('store-recipe'), $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseHas('recipes', [
            'user_id' => $this->user->id,
            'name' => $attributes['name'],
            'recipe' => $attributes['recipe']
        ]);

        $this->assertDatabaseHas('item_recipe', [
            'item_id' => $items[0]->id,
            'recipe_id' => Recipe::first()->id,
            'amount' => $attributes['items'][0]['amount'],
            'precise_amount' => $attributes['items'][0]['precise_amount'],
            'order' => $attributes['items'][0]['order']
        ]);
    }

    public function test_a_user_cannot_create_a_recipe_twice()
    {
        $recipe = RecipeFactory::addRecipe($this->user);

        $response = $this->callApi(route('store-recipe'), [
            'name' => $recipe->name,
            'recipe' => $recipe->recipe,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'recipeAlreadyExists');
    }

    public function test_adding_a_recipe_requires_attributes()
    {
        $this->callApi(route('store-recipe'), ['name' => ''], true)
            ->assertStatus(302);

        $this->callApi(route('store-recipe'), ['name' => 'Spaghetti Bolognese', 'recipe' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Spaghetti Bolognese', 'recipe' => 'A recipe', 'items' => 'Bad item request'];

        $this->callApi(route('store-recipe'), $attributes, true)->assertStatus(302);
    }

    public function test_a_user_can_update_a_recipe()
    {
        $recipe = RecipeFactory::addRecipeWithOneItem($this->user);
        $oldItem = Item::first();
        $newItem = ItemFactory::addItem($this->user);

        $attributes = [
            'name' => 'Updated Recipe Name',
            'recipe' => 'Lorem ipsum updated',
            'items' => [
                ['id' => $newItem->id, 'amount' => 3, 'precise_amount' => '50g', 'order' => 1],
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi($recipe->apiPath() . 'update/', $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);
        $this->assertDatabaseHas('item_recipe', [
            'item_id' => $newItem->id,
            'recipe_id' => $recipe->id,
            'amount' => $attributes['items'][0]['amount'],
            'precise_amount' => $attributes['items'][0]['precise_amount'],
            'order' => $attributes['items'][0]['order']
        ]);
        $this->assertDatabaseMissing('item_recipe', [
            'item_id' => $oldItem->id,
            'recipe_id' => $recipe->id
        ]);
    }

    public function test_a_user_cannot_update_a_recipe_to_have_the_same_name_as_another_recipe()
    {
        $recipe = RecipeFactory::addRecipe($this->user);
        $secondaryRecipe = RecipeFactory::addRecipe($this->user);

        $response = $this->callApi($recipe->apiPath() . 'update/', [
            'name' => $secondaryRecipe->name,
            'recipe' => $recipe->recipe,
            'items' => json_encode([])
        ]);

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'recipeAlreadyExists');
    }

    public function test_updating_a_recipe_requires_attributes()
    {
        $recipe = RecipeFactory::addRecipe($this->user);

        $path = route('update-recipe', ['recipe' => $recipe->id]);

        $this->callApi($path, ['name' => ''], true)
            ->assertStatus(302);

        $this->callApi($path, ['name' => 'Spaghetti Bolognese', 'recipe' => ''], true)
            ->assertStatus(302);

        $attributes = ['name' => 'Spaghetti Bolognese', 'recipe' => 'A recipe', 'items' => 'Bad item request'];

        $this->callApi($path, $attributes, true)->assertStatus(302);
    }

    public function test_a_user_cannot_update_another_users_recipe()
    {
        $secondaryUser = UserFactory::addUser();
        $recipe = RecipeFactory::addRecipe($secondaryUser);

        $this->callApi(route('update-recipe', ['recipe' => $recipe->id]), [
            'name' => 'A name',
            'recipe' => 'A recipe',
            'items' => json_encode([])
        ], true)->assertStatus(403);
    }

    public function test_a_user_can_delete_a_recipe()
    {
        $recipe = RecipeFactory::addRecipeWithTwoItems($this->user);

        $response = $this->callApi(route('destroy-recipe', ['recipe' => $recipe->id]), [], true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertEquals($response['status'], 200);

        $this->assertDatabaseCount('item_recipe', 0);
        $this->assertDatabaseCount('recipes', 0);
        $this->assertDatabaseCount('items', 2);
    }

    public function test_a_user_cannot_delete_another_users_recipe()
    {
        $secondaryUser = UserFactory::addUser();
        $recipe = RecipeFactory::addRecipe($secondaryUser);

        $this->callApi(route('destroy-recipe', ['recipe' => $recipe->id]), [], true)
            ->assertStatus(403);
    }

}
