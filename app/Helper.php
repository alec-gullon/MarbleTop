<?php

namespace App;

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

}
