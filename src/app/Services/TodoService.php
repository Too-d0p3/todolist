<?php

namespace App\Services;

use App\Data\CreateTodoDTO;
use App\Data\UpdateTodoDTO;
use App\Models\Todo;

class TodoService
{
    /**
     * Vytvoří nový úkol
     */
    public function create(CreateTodoDTO $dto): Todo
    {
        return Todo::create([
            'title' => $dto->title,
            'done' => $dto->done,
        ]);
    }

    public function update(Todo $todo, UpdateTodoDTO $dto): Todo
    {
        $todo->update([
            'title' => $dto->title,
            'done'  => $dto->done,
        ]);
        return $todo;
    }

    /**
     * Přepne stav dokončení úkolu (done/undone)
     */
    public function toggleDone(Todo $todo): Todo
    {
        $todo->done = !$todo->done;
        $todo->save();

        return $todo;
    }

    /**
     * Smaže všechny hotové (done) úkoly
     */
    public function deleteAllDone(): int
    {
        return Todo::where('done', true)->delete();
    }

    /**
     * Smaže všechny aktivní (nedone) úkoly
     */
    public function deleteAllActive(): int
    {
        return Todo::where('done', false)->delete();
    }
}
