<?php

namespace App\Vue;

use App\Models\ItemLocation;

use Illuminate\Support\Facades\Auth;

class ItemsAdmin {

    public static function locations()
    {
        $itemLocations = ItemLocation::all();

        $data = [];
        foreach ($itemLocations as $location) {
            $data[$location->id] = [
                'id' => $location->id,
                'name' => $location->name,
                'expanded' => false
            ];
        }

        return $data;
    }

    public static function items()
    {
        $user = Auth::user()->fresh();
        $items = $user->items->sortBy('name');

        $data = [];
        foreach ($items as $item) {
            $data[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'locationId' => $item->location->id
            ];
        }

        return $data;
    }

}
