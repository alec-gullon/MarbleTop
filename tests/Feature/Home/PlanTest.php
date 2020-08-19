<?php

namespace Tests\Feature;

use App\Models\Item;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\CollectionFactory;
use Tests\Setup\PlanFactory;
use Tests\Setup\RecipeFactory;

use Tests\TestCase;

class PlanTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_collection_index_displays_a_users_plans()
    {
        $user = $this->signIn();
        $plan = PlanFactory::addPlan($user);

        $this->get(route('plans'))
            ->assertSee($plan->displayDate())
            ->assertSee('test-count="1"');
    }

    public function test_creating_a_plan_pulls_in_both_recipes_and_collections()
    {
        $user = $this->signIn();
        $collection = CollectionFactory::addCollection($user);
        $recipe = RecipeFactory::addRecipe($user);

        $this->get(route('plans-add'))
            ->assertSee($collection->name)
            ->assertSee($recipe->name)
            ->assertSee('data-recipe-count="2"');
    }

    public function test_viewing_a_plan_displays_its_items()
    {
        $user = $this->signIn();
        $plan = PlanFactory::addPlanWithTwoItems($user);
        $items = Item::all();

        $this->get(route('plan', ['plan' => $plan->id]))
            ->assertSee($items[0]->name)
            ->assertSee($items[1]->name)
            ->assertSee('Fresh')
            ->assertDontSee('Frozen');
    }
}
