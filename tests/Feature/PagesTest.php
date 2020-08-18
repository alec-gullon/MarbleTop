<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_the_homepage_returns_expected_html()
    {
        $response = $this->get(route('homepage'));

        $response->assertStatus(200)
            ->assertSee('Log In');
    }

    public function test_the_create_an_account_page_returns_expected_html()
    {
        $response = $this->get(route('create-account'));

        $response->assertStatus(200)
            ->assertSee('Create an Account');
    }
}
