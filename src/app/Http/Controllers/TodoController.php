<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        \App\Models\Todo::create($data);

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
    public function update(Request $request, int $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return redirect()->route('todos.index')->with('error', 'Úkol již neexistuje.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo->update($data);

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
