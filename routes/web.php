<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return 'Rota funcionando!';
});
Route::get('/login', function () {
    return view('login'); // Ou a view que você está utilizando para carregar o Vue
});
Route::post('/login_auth', [AuthController::class, 'login'])->name('login_auth');

// Route::get('/login', function () {
//     return view('login');
// })->name('login')->withoutMiddleware(['auth']);

//Route::get('tasks', TaskController::class);
// Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
// Route::post('/tarefas/store', [TaskController::class, 'store'])->name('tasks.store');
// Route::delete('/destroy/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
// Route::get('/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
// Route::put('/update/{id}', [TaskController::class, 'update'])->name('tasks.update');
