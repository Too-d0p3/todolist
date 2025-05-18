<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Todo;
use Carbon\Carbon;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_can_be_created_and_shown()
    {
        $response = $this->post('/todos', [
            'title' => 'Koupit rohlíky',
        ]);

        $response->assertRedirect(route('todos.index'));

        $this->get('/todos')
            ->assertSeeText('Koupit rohlíky');
    }

    public function test_it_sets_completed_at_when_marked_as_done(): void
    {
        // Vytvoř úkol jako aktivní
        $todo = Todo::create([
            'title' => 'Udělat test',
            'done' => false,
        ]);

        $this->assertNull($todo->completed_at);

        // Označ ho jako hotový
        $todo->done = true;
        $todo->save();

        $todo->refresh();

        $this->assertNotNull($todo->completed_at);
        $this->assertInstanceOf(Carbon::class, $todo->completed_at);
        $this->assertTrue($todo->done);
    }

    public function test_it_clears_completed_at_when_marked_as_not_done(): void
    {
        // Vytvoř úkol jako aktivní
        $todo = Todo::create([
            'title' => 'Udělat test',
            'done' => false,
        ]);

        // Označ jako hotový
        $todo->done = true;
        $todo->save();

        $this->assertNotNull($todo->completed_at);

        // A teď ho označ zpět jako nedokončený
        $todo->done = false;
        $todo->save();

        $todo->refresh();

        $this->assertNull($todo->completed_at);
        $this->assertFalse($todo->done);
    }
}
