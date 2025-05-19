<?php

namespace App\Livewire;

use App\Services\TodoService;
use Livewire\Component;
use App\Models\Todo;

/**
 * @property-read Todo|null $todo
 */
class TodoStatusToggle extends Component
{
    public int $todoId;
    private ?Todo $todoCache = null;

    public function mount(int $todoId)
    {
        $this->todoId = $todoId;
    }

    public function getTodoProperty(): ?Todo
    {
        return $this->todoCache ??= Todo::find($this->todoId);
    }

    public function toggle(TodoService $todoService)
    {
        if ($this->todo) {
            $todoService->toggleDone($this->todo);
            $this->dispatch('todoUpdated');
        }
    }

    public function render()
    {
        if (!$this->todo) {
            return view('livewire.todo-missing');
        }

        return view('livewire.todo-status-toggle', [
            'todo' => $this->todo,
        ]);
    }
}
