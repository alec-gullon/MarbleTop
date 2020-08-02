<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function test_login_redirects_correctly()
    {
        $user = factory('App\User')->create();

        $response = $this->post(route('attempt-login'), [
            'email' => $user->email,
            'password' => $user->password
        ]);

        $response->assertStatus(302);
    }
}
