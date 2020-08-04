<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ApiTestCase extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }

    protected function callApi($path, $arguments = [], $rawResponse = false)
    {
        $arguments = array_merge($arguments, ['api_token' => $this->user->api_token]);

        $response = $this->post($path, $arguments);

        if ($rawResponse) {
            return $response;
        }

        return json_decode($response->getContent());
    }

    protected function assertDatabaseCount($table, $count)
    {
        $existingCount = \DB::table($table)->count();
        $this->assertEquals($count, $existingCount);
    }
}
