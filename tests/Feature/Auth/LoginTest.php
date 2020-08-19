<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_login_fails_with_bad_email()
    {
        $user = factory('App\User')->create();

        $response = $this->post(route('attempt-login'), [
            'email' => $user->email,
            'password' => 'badPassword'
        ]);

        $response->assertSessionHasErrors(['email']);

        $response = $this->post(route('attempt-login'), [
            'email' => 'bad@email.co.uk',
            'password' => 'password'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_signed_in_user_cannot_reach_login_page()
    {
        $this->signIn();

        $this->get(route('login'))
            ->assertStatus(302);
    }

    public function test_signed_in_user_cannot_reattempt_login()
    {
        $this->post(route('attempt-login'), [
            'email' => 'random@email.com',
            'password' => 'password'
        ])->assertStatus(302);
    }

    public function test_login_redirects()
    {
        $user = factory('App\User')->create();

        $response = $this->post(route('attempt-login'), [
            'email' => $user->email,
            'password' => $user->password
        ]);

        $response->assertStatus(302);
    }
}
