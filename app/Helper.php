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

    public static function recipesData($user) {
        $user->refresh();
        $recipes = $user->recipes->sortBy('name');

        $data = [];
        foreach ($recipes as $recipe) {
            $datum = [
                'id' => $recipe->id,
                'name' => $recipe->name
            ];
            $data[] = $datum;
        }
        return $data;
    }

    public static function collectionsData($user) {
        $user->refresh();
        $collections = $user->collections->sortBy('name');

        $data = [];
        foreach ($collections as $collection) {
            $datum = [
                'id' => $collection->id,
                'name' => $collection->name
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
