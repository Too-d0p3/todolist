@extends('layouts.app')

@section('containerHeight', 'h-auto')
@section('content')

    <x-form-wrapper title="Přidat úkol">
        @include('todos._form', [
            'action' => route('todos.store'),
            'todo' => new \App\Models\Todo
        ])
    </x-form-wrapper>
@endsection
