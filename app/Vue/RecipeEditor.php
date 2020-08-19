<?php

namespace App\Vue;

use Illuminate\Support\Facades\Auth;

class RecipeEditor
{
    public static function items($recipe)
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

        foreach ($recipe->items as $item) {
            $data[$item->id]['selected'] = true;
            $data[$item->id]['amount'] = (float)$item->pivot->amount;
            $data[$item->id]['order'] = (int)$item->pivot->order;
            $data[$item->id]['preciseAmount'] = $item->pivot->precise_amount;
        }

        return $data;
    }
}
