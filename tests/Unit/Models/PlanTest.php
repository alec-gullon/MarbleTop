<?php

namespace Tests\Unit\Models;

use App\Models\ItemLocation;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Setup\PlanFactory;
use Tests\TestCase;

class PlanTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_it_can_sort_its_items_by_location()
    {
        $user = factory('App\User')->create();
        $plan = PlanFactory::addPlanWithTwoItems($user);

        $itemsByLocation = $plan->itemsByLocation();

        $this->assertEquals(count($itemsByLocation), 1);
        $this->assertEquals(count($itemsByLocation[1]['items']), 2);

        $this->assertEquals($itemsByLocation[1]['model'], ItemLocation::find(1));
    }

}
