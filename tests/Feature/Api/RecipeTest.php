<?php

namespace Tests\Feature\Api;

use App\Models\Item;
use App\Models\Recipe;

use Tests\ApiTestCase;

use Tests\Setup\RecipeFactory;
use Tests\Setup\ItemFactory;
use Tests\Setup\UserFactory;

class RecipeTest extends ApiTestCase
{
    public function test_a_user_can_create_a_recipe()
    {
        $items = ItemFactory::addTwoItems($this->user);

        $attributes = [
            'name' => 'Spaghetti Bolognese',
            'recipe' => 'Lorem ipsum',
            'description' => 'My happy description',
            'items' => [
                ['id' => $items[0]->id, 'amount' => 1.5, 'precise_amount' => '100g', 'order' => 1],
                ['id' => $items[1]->id, 'amount' => 2.5, 'precise_amount' => '200g', 'order' => 2]
            ],
            'image_id' => 10,
            'cook_time' => 30,
            'serving_size' => 2
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
            'recipe' => $attributes['recipe'],
            'description' => $attributes['description'],
            'image_id' => $attributes['image_id'],
            'cook_time' => $attributes['cook_time'],
            'serving_size' => $attributes['serving_size']
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
            'description' => 'My happy description',
            'items' => [
                ['id' => $newItem->id, 'amount' => 3, 'precise_amount' => '50g', 'order' => 1],
            ],
            'image_id' => 10,
            'cook_time' => 30,
            'serving_size' => 2
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi($recipe->apiPath() . 'update/', $submission, true)
            ->assertSessionHas('message')
            ->decodeResponseJson();

        $this->assertDatabaseHas('recipes', [
            'id' => $recipe->id,
            'serving_size' => $attributes['serving_size']
        ]);

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

    public function test_a_user_can_mark_a_recipe_as_published()
    {
        $recipe = RecipeFactory::addRecipe($this->user);

        $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'user_id' => $this->user->id,
            'id' => $recipe->id,
            'published' => true
        ]);
    }

    public function test_a_user_can_mark_a_recipe_as_private()
    {
        $recipe = RecipeFactory::addPublishedRecipe($this->user);

        $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'user_id' => $this->user->id,
            'id' => $recipe->id,
            'published' => false
        ]);
    }

    public function test_when_a_user_publishes_a_recipe_a_slug_is_generated()
    {
        $recipe = RecipeFactory::addRecipe($this->user);
        $recipe->update(['name' => 'Spaghetti Bolognese']);

        $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'user_id' => $this->user->id,
            'id' => $recipe->id,
            'slug' => 'spaghetti-bolognese'
        ]);
    }

    public function test_two_recipes_cannot_have_the_same_slug()
    {
        $alec = $this->user;
        $lucy = UserFactory::addUser();

        $recipe = RecipeFactory::addRecipe($alec);
        $duplicateRecipe = RecipeFactory::addRecipe($lucy);

        $recipe->update(['name' => 'Spaghetti Bolognese']);
        $duplicateRecipe->update(['name' => 'Spaghetti Bolognese']);

        $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->user = $lucy;

        $this->callApi(route('recipe-toggle-publish', ['recipe' => $duplicateRecipe->id]));

        $this->assertDatabaseHas('recipes', [
            'user_id' => $this->user->id,
            'id' => $duplicateRecipe->id,
            'slug' => 'spaghetti-bolognese-' . $lucy->id
        ]);
    }

    public function test_a_user_cannot_publish_a_recipe_without_the_required_attributes()
    {
        $recipe = RecipeFactory::addRecipe($this->user);
        $recipe->update([
            'description' => '',
            'cook_time' => '',
            'serving_size' => ''
        ]);

        $response = $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'descriptionIsRequired');

        $recipe->update(['description' => 'My happy description']);

        $response = $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'servingSizeIsRequired');

        $recipe->update(['serving_size' => '20']);

        $response = $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertEquals($response->status, 400);
        $this->assertEquals($response->error, 'cookTimeIsRequired');
    }

    public function test_unpublishing_a_recipe_removes_the_slug()
    {
        $recipe = RecipeFactory::addPublishedRecipe($this->user);

        $this->callApi(route('recipe-toggle-publish', ['recipe' => $recipe->id]));

        $this->assertDatabaseHas('recipes', [
            'user_id' => $this->user->id,
            'id' => $recipe->id,
            'slug' => ''
        ]);
    }

    public function test_a_user_cannot_set_serving_size_or_cooking_time_to_unexpected_values()
    {
        $this->withoutExceptionHandling();

        $recipe = RecipeFactory::addRecipe($this->user);

        $attributes = [
            'name' => 'Updated Recipe Name',
            'recipe' => 'Lorem ipsum updated',
            'description' => 'My happy description',
            'items' => json_encode([]),
            'cook_time' => 35,
            'serving_size' => 9
        ];

        $path = route('update-recipe', ['recipe' => $recipe->id]);

        $response = $this->callApi($path, $attributes);
        $this->assertEquals($response->error, 'invalidCookTime');

        $attributes['cook_time'] = 30;

        $response = $this->callApi($path, $attributes);
        $this->assertEquals($response->error, 'invalidServingSize');

    }

}
