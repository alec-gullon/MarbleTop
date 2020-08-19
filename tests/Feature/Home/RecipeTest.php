<?php

namespace Tests\Feature;

use App\Models\Item;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\ItemFactory;
use Tests\Setup\RecipeFactory;

use Tests\TestCase;

class RecipeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_recipe_displays_edit_icon()
    {
        $user = $this->signIn();
        $recipe = RecipeFactory::addRecipe($user);

        $this->get(route('recipe-details', ['recipe' => $recipe->id]))
            ->assertSee('header with-icon');
    }

    public function test_recipe_index_sets_recipes_as_the_selected_area()
    {
        $this->signIn();

        $this->get(route('recipes'))
            ->assertSee('is-selected _recipe');
    }

    public function test_recipe_index_displays_a_users_recipes()
    {
        $user = $this->signIn();
        $recipe = RecipeFactory::addRecipe($user);

        $this->get(route('recipes'))
            ->assertSee($recipe->name);
    }

    public function test_add_recipe_form_pulls_in_user_items()
    {
        $user = $this->signIn();
        $items = ItemFactory::addTwoItems($user);

        $this->get(route('recipes-add'))
            ->assertSee($items[0]->name)
            ->assertSee($items[1]->name);
    }

    public function test_viewing_a_recipe_displays_the_recipe()
    {
        $user = $this->signIn();
        $recipe = RecipeFactory::addRecipe($user);

        $this->get(route('recipe-details', ['recipe' => $recipe->id]))
            ->assertSee($recipe->displayRecipe());
    }

    public function test_viewing_a_recipe_displays_the_ingredients()
    {
        $user = $this->signIn();
        $recipe = RecipeFactory::addRecipeWithTwoItems($user);
        $items = Item::all();

        $this->get(route('recipe-details', ['recipe' => $recipe->id]))
            ->assertSee($items[0]->name)
            ->assertSee($items[1]->name);
    }

    public function test_editing_a_recipe_displays_the_ingredients()
    {
        $user = $this->signIn();
        $recipe = RecipeFactory::addRecipeWithTwoItems($user);
        $items = Item::all();

        $this->get(route('recipe-edit', ['recipe' => $recipe->id]))
            ->assertSee($items[0]->name)
            ->assertSee($items[1]->name);
    }
}
