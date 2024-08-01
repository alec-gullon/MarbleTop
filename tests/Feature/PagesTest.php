<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_the_homepage_returns_expected_html()
    {
        $response = $this->get(route('homepage'));

        $response->assertStatus(200)
            ->assertSee('Log In');
    }

    public function test_the_homepage_returns_expected_html_when_user_signs_in()
    {
        $this->signIn();

        $this->get(route('homepage'))
            ->assertSee('>Home<', false)
            ->assertDontSee('>Log In<', false);
    }

    public function test_the_users_api_token_is_set_if_they_are_signed_in()
    {
        $user = $this->signIn();

        $this->get(route('homepage'))
            ->assertSee("document.global.apiToken = '{$user->api_token}'", false);
    }

    public function test_primary_nav_is_passed_authenticated_false_if_user_not_signed_in()
    {
        $this->get(route('homepage'))
            ->assertSee(':authenticated="false"', false);
    }

    public function test_the_create_an_account_page_returns_expected_html()
    {
        $response = $this->get(route('create-account'));

        $response->assertStatus(200)
            ->assertSee('Create an Account');
    }
}
