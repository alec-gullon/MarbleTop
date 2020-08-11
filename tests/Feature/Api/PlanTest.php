<?php

namespace Tests\Feature\Api;

use Tests\ApiTestCase;
use Tests\Setup\ItemFactory;

class PlanTest extends ApiTestCase
{
    public function test_a_user_can_create_a_plan()
    {
        $items = ItemFactory::addTwoItems($this->user);

        $attributes = [
            'items' => [
                ['id' => $items[0]->id, 'amount' => 1.5],
                ['id' => $items[1]->id, 'amount' => 2.5]
            ]
        ];

        $submission = $attributes;
        $submission['items'] = json_encode($submission['items']);

        $response = $this->callApi(route('store-plan'), $submission);

        $this->assertEquals($response->status, 200);

        $this->assertDatabaseHas('plans', [
            'user_id' => $this->user->id
        ]);
    }
}
