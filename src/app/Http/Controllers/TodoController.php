<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;
use App\Data\CreateTodoDTO;
use App\Data\UpdateTodoDTO;

class TodoController extends Controller
{
    protected TodoService $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::orderByDesc('created_at')->get();
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $dto = new CreateTodoDTO(
            $request->input('title'),
            $request->input('done', false)
        );

        $this->todoService->create($dto);

        return redirect()->route('todos.index')->with('success', 'Úkol byl vytvořen.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $dto = new UpdateTodoDTO(
            $request->input('title'),
            $request->input('done', $todo->done)
        );

        $this->todoService->update($todo, $dto);

        return redirect()->route('todos.index')->with('success', 'Úkol byl upraven.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Úkol byl smazán.');
    }
}
