<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_view_locked_pages()
    {
        $this->get(route('ingredients'))
            ->assertRedirect(route('login'));

        $this->get(route('home'))
            ->assertRedirect(route('login'));
    }

    public function test_guests_cannot_access_api_routes()
    {
        $this->post(route('add-ingredient'), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);

        $this->post(route('update-ingredient'), ['api_token' => 'bad_api_token'])
            ->assertStatus(302);
    }
}
