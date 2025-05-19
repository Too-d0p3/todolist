<?php

namespace App\Livewire;

use App\Services\TodoService;
use Livewire\Component;
use App\Models\Todo;

class TodoListActive extends Component
{
    protected $listeners = ['todoUpdated' => '$refresh'];

    public function render()
    {
        $todos = Todo::where('done', false)->orderByDesc('created_at')->get();
        return view('livewire.todo-list-active', compact('todos'));
    }

    public function deleteAllActive(TodoService $todoService)
    {
        $todoService->deleteAllActive();
        $this->dispatch('todoUpdated');
    }
}
