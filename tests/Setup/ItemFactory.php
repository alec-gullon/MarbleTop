<?php

namespace Tests\Setup;

use App\Models\Item;

class ItemFactory
{
    public static function addItem($user)
    {
        return $user->addItem([
            'name' => 'Red Onion',
            'location_id' => 1
        ]);
    }

    public static function addTwoItems($user)
    {
        $user->addItem([
            'name' => 'Red Onion',
            'location_id' => 1
        ]);

        $user->addItem([
            'name' => 'White Onion',
            'location_id' => 1
        ]);

        return Item::all();
    }
}
