<?php

namespace Tests\Unit\Models;

use App\Models\Item;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\ItemFactory;
use Tests\Setup\RecipeFactory;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory('App\User')->create();
    }

    public function test_it_can_attach_items()
    {
        $recipe = RecipeFactory::addRecipe($this->user);
        ItemFactory::addTwoItems($this->user);
        $items = Item::all();

        $item1 = [
            'id' => $items[0]->id,
            'amount' => 1,
            'precise_amount' => '100g',
            'order' => 0
        ];

        $item2 = [
            'id' => $items[1]->id,
            'amount' => 2,
            'precise_amount' => 'x2',
            'order' => 1
        ];

        $recipe->attachItems([$item1, $item2]);

        $this->assertDatabaseHas(
            'item_recipe',
            array_merge($item1, ['recipe_id' => $recipe->id])
        );
        $this->assertDatabaseHas(
            'item_recipe',
            array_merge($item2, ['recipe_id' => $recipe->id])
        );
    }

    public function test_it_has_a_display_recipe()
    {
        $recipe = RecipeFactory::addRecipe($this->user);
        $recipe->recipe = 'My first paragraph.

My second paragraph.

Another paragraph';

        $this->assertEquals(
            $recipe->displayRecipe(),
            '<p>My first paragraph.</p><p>My second paragraph.</p><p>Another paragraph</p>'
        );
    }

    public function test_it_can_distinguish_between_primary_and_secondary_items()
    {
        $recipe = RecipeFactory::addRecipeWithTwoItems($this->user);

        $recipe->items[1]->pivot->precise_amount = '';

        $primaryItem = $recipe->items[0];
        $secondaryItem = $recipe->items[1];

        $this->assertEquals($recipe->primaryItems()[0], $primaryItem);
        $this->assertEquals($recipe->secondaryItems()[0], $secondaryItem);

        $this->assertEquals(count($recipe->primaryItems()), 1);
        $this->assertEquals(count($recipe->secondaryItems()), 1);
    }

}
