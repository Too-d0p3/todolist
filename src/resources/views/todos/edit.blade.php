@extends('layouts.app')

@section('containerHeight', 'h-auto')
@section('content')
    <x-form-wrapper title="Upravit úkol">
        @include('todos._form', [
            'action' => route('todos.update', $todo),
            'method' => 'PUT',
            'todo' => $todo
        ])
    </x-form-wrapper>
@endsection
