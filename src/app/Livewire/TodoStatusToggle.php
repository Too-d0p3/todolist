<?php

namespace App\Livewire;

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

    public function toggle()
    {
        if ($this->todo) {
            $this->todo->done = !$this->todo->done;
            $this->todo->save();
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
