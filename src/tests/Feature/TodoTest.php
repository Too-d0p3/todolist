<?php

namespace Tests\Feature;

use App\Data\UpdateTodoDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\TodoService;
use App\Data\CreateTodoDTO;
use App\Models\Todo;
use Carbon\Carbon;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_todo_can_be_created_and_shown()
    {
        // Feature test - stále přes HTTP request, tedy pole (uživatel/fe)
        $response = $this->post('/todos', [
            'title' => 'Koupit rohlíky',
        ]);

        $response->assertRedirect(route('todos.index'));

        $this->get('/todos')
            ->assertSeeText('Koupit rohlíky');
    }

    public function test_it_sets_completed_at_when_marked_as_done(): void
    {
        $service = new TodoService();

        // Vytvoř úkol jako aktivní přes DTO+service
        $dto = new CreateTodoDTO('Udělat test', false);
        $todo = $service->create($dto);

        $this->assertNull($todo->completed_at);

        // Označ jako hotový přes service
        $service->toggleDone($todo->refresh());

        $todo->refresh();

        $this->assertNotNull($todo->completed_at);
        $this->assertInstanceOf(Carbon::class, $todo->completed_at);
        $this->assertTrue($todo->done);
    }

    public function test_it_clears_completed_at_when_marked_as_not_done(): void
    {
        $service = new TodoService();

        // Vytvoř úkol jako aktivní přes DTO+service
        $dto = new CreateTodoDTO('Udělat test', false);
        $todo = $service->create($dto);

        // Označ jako hotový přes service
        $service->toggleDone($todo->refresh());
        $this->assertNotNull($todo->fresh()->completed_at);

        // A teď ho označ zpět jako nedokončený přes service
        $service->toggleDone($todo->refresh());
        $todo->refresh();

        $this->assertNull($todo->completed_at);
        $this->assertFalse($todo->done);
    }

    public function test_todo_validation_fails_without_title()
    {
        // Feature test přes HTTP request (validace FormRequest v kontroleru)
        $response = $this->post('/todos', [
            'title' => '', // prázdný název
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseMissing('todos', ['title' => '']);
    }

    public function test_todo_can_be_deleted()
    {
        $service = new TodoService();

        $dto = new CreateTodoDTO('Smazat úkol', false);
        $todo = $service->create($dto);

        $this->assertDatabaseHas('todos', ['title' => 'Smazat úkol']);

        $todo->delete();

        $this->assertDatabaseMissing('todos', ['title' => 'Smazat úkol']);
    }

    public function test_delete_all_done_and_active()
    {
        $service = new TodoService();

        // Přidej hotové a aktivní úkoly
        $service->create(new CreateTodoDTO('Hotový 1', true));
        $service->create(new CreateTodoDTO('Hotový 2', true));
        $service->create(new CreateTodoDTO('Aktivní 1', false));
        $service->create(new CreateTodoDTO('Aktivní 2', false));

        $this->assertEquals(2, Todo::where('done', true)->count());
        $this->assertEquals(2, Todo::where('done', false)->count());

        $service->deleteAllDone();
        $this->assertEquals(0, Todo::where('done', true)->count());

        $service->deleteAllActive();
        $this->assertEquals(0, Todo::where('done', false)->count());
    }

    public function test_todo_can_be_updated()
    {
        $service = new TodoService();

        $todo = $service->create(new CreateTodoDTO('Starý název', false));
        $this->assertEquals('Starý název', $todo->title);

        $updateDto = new UpdateTodoDTO('Nový název', true);
        $service->update($todo, $updateDto);

        $todo->refresh();
        $this->assertEquals('Nový název', $todo->title);
        $this->assertTrue($todo->done);
    }

    public function test_todo_title_must_be_unique()
    {
        // Vytvoř první úkol
        $this->post('/todos', [
            'title' => 'Duplicitní název',
        ]);
        $this->assertDatabaseHas('todos', ['title' => 'Duplicitní název']);

        // Pokus o vytvoření stejného názvu
        $response = $this->post('/todos', [
            'title' => 'Duplicitní název',
        ]);

        $response->assertSessionHasErrors('title');
        // V DB zůstává stále jen jeden
        $this->assertEquals(1, \App\Models\Todo::where('title', 'Duplicitní název')->count());
    }

    public function test_todo_title_must_be_unique_on_update()
    {
        $this->post('/todos', ['title' => 'První název']);
        $this->post('/todos', ['title' => 'Druhý název']);

        $todo = \App\Models\Todo::where('title', 'Druhý název')->first();

        $response = $this->patch("/todos/{$todo->id}", [
            'title' => 'První název',
        ]);

        $response->assertSessionHasErrors('title');
    }


}
