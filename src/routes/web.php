<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', fn() => redirect()->route('todos.index'));
Route::resource('todos', TodoController::class);
