<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);
Route::post('/tarefas/store', [TaskController::class, 'store'])->name('tasks.store');
Route::delete('/destroy/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::put('/update/{id}', [TaskController::class, 'update'])->name('tasks.update');
