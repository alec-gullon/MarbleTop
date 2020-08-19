<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\CollectionFactory;
use Tests\Setup\ItemFactory;
use Tests\Setup\RecipeFactory;

use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
    }

    public function test_a_user_can_add_a_recipe()
    {
        $name = 'Spaghetti Bolognese';
        $recipeText = 'My example recipe';

        $recipe = $this->user->addRecipe(['name' => $name, 'recipe' => $recipeText]);

        $this->assertCount(1, $this->user->recipes);
        $this->assertTrue($this->user->recipes->contains($recipe));
        $this->assertDatabaseHas('recipes', [
            'name' => $name,
            'recipe' => $recipeText
        ]);
    }

    public function test_a_user_can_add_a_collection()
    {
        $name = 'Kitchen Essentials';

        $collection = $this->user->addCollection(['name' => $name]);

        $this->assertCount(1, $this->user->collections);
        $this->assertTrue($this->user->collections->contains($collection));
        $this->assertDatabaseHas('collections', [
            'name' => $name,
        ]);
    }

    public function test_a_user_can_add_a_plan()
    {
        $plan = $this->user->addPlan();

        $this->assertCount(1, $this->user->plans);
        $this->assertTrue($this->user->plans->contains($plan));
        $this->assertDatabaseHas('plans', [
            'created_at' => $plan->created_at,
        ]);
    }

    public function test_a_user_can_add_an_item()
    {
        $attributes = [
            'name' => 'Name',
            'location_id' => 1
        ];

        $item = $this->user->addItem($attributes);

        $this->assertCount(1, $this->user->items);
        $this->assertTrue($this->user->items->contains($item));
        $this->assertDatabaseHas('items', $attributes);
    }

    public function test_a_user_can_determine_if_they_own_an_item_by_name()
    {
        $item = ItemFactory::addItem($this->user);

        $this->assertEquals($this->user->hasItem($item->name), true);
        $this->assertEquals($this->user->hasItem($item->name . 'something-else'), false);
    }

    public function test_a_user_can_determine_if_they_own_a_recipe_by_name()
    {
        $recipe = RecipeFactory::addRecipe($this->user);

        $this->assertEquals($this->user->hasRecipe($recipe->name), true);
        $this->assertEquals($this->user->hasRecipe($recipe->name . 'something-else'), false);
    }

    public function test_a_user_can_determine_if_they_own_a_collection_by_name()
    {
        $collection = CollectionFactory::addCollection($this->user);

        $this->assertEquals($this->user->hasCollection($collection->name), true);
        $this->assertEquals($this->user->hasCollection($collection->name . 'something-else'), false);
    }

}
