<?php

namespace Tests\Setup;

use Illuminate\Support\Str;

class GroupFactory
{
    public static function addGroup($user)
    {
        return $user->addGroup(['name' => Str::random(16)]);
    }

    public static function addGroupWithOneItem($user)
    {
        $group = self::addGroup($user);

        $item = ItemFactory::addItem($user);

        $group->items()->attach($item, ['amount' => 1]);

        return $group;
    }

    public static function addGroupWithTwoItems($user)
    {
        $group = self::addGroup($user);

        $items = ItemFactory::addTwoItems($user);

        $group->items()->attach($items[0], ['amount' => 1]);
        $group->items()->attach($items[1], ['amount' => 1.5]);

        return $group;
    }
}
