
@extends('layout')
@include('partials.header')
@section('content')
    <div class="container-fluid px-5">
        <h2>Gerenciador de tarefas</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
            Adicionar Tarefa
        </button>
        <h2 class="mt-5">Tarefas cadastradas</h2>
        <table id="tableTarefas" class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tarefa</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Criado em:</th>
                    <th>Alterado em:</th>
                    <th>Categorias:</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)  
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>{{ $task->updated_at }}</td>
                        <td>
                            @foreach($task->categories as $category)
                                {{ $category->title }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" data-id="{{ $task->id }}" onclick="confirmDelete(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                            <button class="btn btn-warning btn-edit btn-sm" data-id="{{ $task->id }}">
                                <i class="bi bi-pencil-fill"></i> 
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('partials.modal')
@endsection
@include('partials.footer')