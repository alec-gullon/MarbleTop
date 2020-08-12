<?php

namespace Tests\Setup;

use Illuminate\Support\Str;

class CollectionFactory
{
    public static function addCollection($user)
    {
        return $user->addCollection(['name' => Str::random(16)]);
    }

    public static function addCollectionWithOneItem($user)
    {
        $collection = self::addCollection($user);

        $item = ItemFactory::addItem($user);

        $collection->items()->attach($item, ['amount' => 1]);

        return $collection;
    }

    public static function addCollectionWithTwoItems($user)
    {
        $collection = self::addCollection($user);

        $items = ItemFactory::addTwoItems($user);

        $collection->items()->attach($items[0], ['amount' => 1]);
        $collection->items()->attach($items[1], ['amount' => 1.5]);

        return $collection;
    }
}
