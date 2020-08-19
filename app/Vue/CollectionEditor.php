<?php

namespace App\Vue;

use Illuminate\Support\Facades\Auth;

class CollectionEditor
{
    public static function items($collection)
    {
        $items = Auth::user()->items->sortBy('name');

        $data = [];
        foreach ($items as $item) {
            $data[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'locationId' => $item->location->id,
                'selected' => false,
                'amount' => 1
            ];
        }

        foreach ($collection->items as $item) {
            $data[$item->id]['selected'] = true;
            $data[$item->id]['amount'] = (float)$item->pivot->amount;
        }

        return $data;
    }
}
