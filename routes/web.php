<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});
Route::get('/login', function () {
    return view('login');
});
Route::post('/login_auth', [AuthController::class, 'login'])->name('login_auth');
Route::post('/logout', function () {
    Auth::logout();
    return response()->json(['message' => 'Logout realizado com sucesso']);
});

Route::get('/categorias', [TaskController::class, 'getCategorias'])->name('tasks.categorias');
Route::get('/tarefas', [TaskController::class, 'index'])->name('tarefas.index');
Route::post('/tarefas/store', [TaskController::class, 'store'])->name('tarefas.store');
Route::delete('/tarefas-destroy', [TaskController::class, 'destroy'])->name('tarefas.destroy');
Route::get('/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::put('/tarefas-update', [TaskController::class, 'update'])->name('tarefas.update');

