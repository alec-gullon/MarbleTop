<?php

namespace App;

use App\Models\ItemLocation;

class Helper {

    public static function itemsData($user) {
        $user->refresh();
        $items = $user->items->sortBy('name');

        $itemsData = [];
        foreach ($items as $item) {
            $itemData = [
                'id' => $item->id,
                'name' => $item->name,
                'locationId' => $item->location->id
            ];
            $itemsData[$item->id] = $itemData;
        }

        return $itemsData;
    }

    public static function mealsData($user) {
        $user->refresh();
        $meals = $user->meals->sortBy('name');

        $data = [];
        foreach ($meals as $meal) {
            $datum = [
                'id' => $meal->id,
                'name' => $meal->name
            ];
            $data[] = $datum;
        }
        return $data;
    }

    public static function groupsData($user) {
        $user->refresh();
        $groups = $user->groups->sortBy('name');

        $data = [];
        foreach ($groups as $group) {
            $datum = [
                'id' => $group->id,
                'name' => $group->name
            ];
            $data[] = $datum;
        }
        return $data;
    }

    public static function locationsData() {
        $itemLocations = ItemLocation::all();

        $data = [];
        foreach ($itemLocations as $location) {
            $datum = [
                'id' => $location->id,
                'name' => $location->name
            ];
            $data[$location->id] = $datum;
        }

        return $data;

    }

    public static function plansData($user) {
        $user->refresh();
        $plans = $user->plans->sortByDesc('created_at');

        $data = [];
        foreach ($plans as $plan) {
            $datum = [
                'id' => $plan->id,
                'created_at' => $plan->created_at
            ];
            $data[] = $datum;
        }
        return $data;
    }

}
