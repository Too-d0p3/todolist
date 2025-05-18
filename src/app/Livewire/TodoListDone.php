<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;

class TodoListDone extends Component
{
    protected $listeners = ['todoUpdated' => '$refresh'];

    public function render()
    {
        $todos = Todo::where('done', true)->orderByDesc('completed_at')->get();
        return view('livewire.todo-list-done', compact('todos'));
    }

    public function deleteAllDone()
    {
        Todo::where('done', true)->delete();
        $this->dispatch('todoUpdated');
    }
}
