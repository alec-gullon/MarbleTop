<?php

namespace Tests\Setup;

class PlanFactory
{
    public static function addPlan($user)
    {
        return $user->addPlan();
    }

    public static function addPlanWithTwoItems($user)
    {
        $plan = self::addPlan($user);

        $items = ItemFactory::addTwoItems($user);

        $plan->items()->attach($items[0], ['amount' => 1]);
        $plan->items()->attach($items[1], ['amount' => 1.5]);

        return $plan;
    }
}
