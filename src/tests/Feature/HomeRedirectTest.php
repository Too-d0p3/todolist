<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_todo_index(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('todos.index'));

        $response->assertStatus(302);

        $followed = $this->get(route('todos.index'));
        $followed->assertStatus(200);
    }
}
