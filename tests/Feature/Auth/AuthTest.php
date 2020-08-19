<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_guests_cannot_view_locked_pages()
    {
        $this->get(route('items'))
            ->assertRedirect(route('login'));

        $this->get(route('home'))
            ->assertRedirect(route('login'));
    }

    public function test_guests_cannot_access_api_routes()
    {
        $this->post(route('store-item'), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);

        $this->post(route('update-item', ['item' => 1]), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);

        $this->post(route('destroy-item', ['item' => 1]), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);

        $this->post(route('store-recipe'), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);

        $this->post(route('update-recipe', ['item' => 1]), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);

        $this->post(route('destroy-recipe', ['item' => 1]), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);
    }
}
