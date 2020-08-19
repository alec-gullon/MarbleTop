<?php

namespace App\Vue;

use Illuminate\Support\Facades\Auth;

class RecipeCreator
{

    public static function items()
    {
        $items = Auth::user()->items->sortBy('name');

        $data = [];
        foreach ($items as $item) {
            $data[$item->id] = [
                'id' => $item->id,
                'name' => $item->name,
                'locationId' => $item->location->id,
                'selected' => false,
                'amount' => 1,
                'preciseAmount' => '',
                'order' => -1
            ];
        }

        return $data;
    }

}
