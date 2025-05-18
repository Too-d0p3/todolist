@extends('layouts.app')

@section('content')
    <div class="overflow-hidden h-full">
        <div class="flex justify-between items-center mb-1">
            <div class="flex items-center">
                <i class="fa-solid fa-list-ul mr-2 text-base"></i> <h1 class="text-base font-semibold"> To-Do List</h1>
            </div>
            <a href="{{ route('todos.create') }}" class="hover:text-green-500 text-base"><i class="fa-solid fa-plus"></i></a>
        </div>


        <div class="flex flex-col h-full">
            <div class="h-[50%] max-h-[50%]">
                @livewire('todo-list-active')
            </div>
            <div class="mt-2 h-[50%] max-h-[50%] h-full">
                @livewire('todo-list-done')
            </div>
        </div>
    </div>
@endsection
