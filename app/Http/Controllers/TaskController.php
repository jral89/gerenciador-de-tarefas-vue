<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $tarefas = Task::with('categories')
        ->when($user->admin === '0', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();
        
        return response()->json($tarefas);        
 
    }

    public function getCategorias()
    {
        $categorias = Category::all();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'titulo' => 'required|string|min:3',
            'descricao' => 'required|string|min:5',
            'status' => 'required|in:pendente,em_andamento,completada',
            'categorias' => 'array'
        ]);
    
        $task = new Task();
        $task->title = $validated['titulo'];
        $task->description = $validated['descricao'];
        $task->status = $validated['status'];
        $task->user_id = $user->id;
        $task->admin = $user->admin;
        $task->save();
    
        if (isset($validated['categorias'])) {
            $task->categories()->sync($validated['categorias']);
        }
    
        return response()->json(['message' => 'Tarefa cadastrada com sucesso!']);
    }

    public function show(string $id)
    {
        $task = Task::with('categories')->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->title = $request->input('titulo');
        $task->description = $request->input('descricao');
        $task->status = $request->input('status');
        $task->save();
        
        $task->categories()->sync($request->input('categorias', []));

        return response()->json(['message' => 'Tarefa atualizada com sucesso!']);
    }

    public function destroy(Request $request)
    {
        $task = Task::find($request->id);
    
        if ($task) {
            $task->delete();
            return response()->json(['message' => 'Tarefa excluída com sucesso.']);
        }

        return response()->json(['message' => 'Tarefa não encontrada.'], 404);
    }
}
