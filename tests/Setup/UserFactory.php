<?php

namespace Tests\Setup;

class UserFactory
{
    public static function addUser()
    {
        return factory('App\User')->create();
    }
}
