<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('index');
});

Route::get('/', [TodoController::class, 'index']);
Route::post('/add', [TodoController::class, 'add']);
Route::post('/update/{id}', [TodoController::class, 'update']);
Route::get('/delete/{id}', [TodoController::class, 'delete']);
Route::get('/done/{id}', [TodoController::class, 'done']);
