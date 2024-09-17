<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Cadastro de Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cadastroTarefasForm" data-action="{{ route('tasks.store') }}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título da tarefa">
                        </div>
                        <div class="col-md-6">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva a tarefa">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 position-relative">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pendente">Pendente</option>
                                <option value="em_andamento">Em Andamento</option>
                                <option value="completada">Completada</option>
                            </select>
                            <i class="bi bi-caret-down-fill position-absolute" 
                            style="right: 15px; top: 36px; pointer-events: none;"></i>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label for="categorias" class="form-label">Categorias</label>
                            <select class="form-control" id="categorias" name="categorias[]" multiple>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->title }}</option>
                                @endforeach
                            </select>
                            <i class="bi bi-caret-down-fill position-absolute" 
                            style="right: 15px; top: 36px; pointer-events: none;"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Editar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <input type="hidden" id="editTaskId" name="id">
                    <div class="mb-3">
                        <label for="editTitulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="editTitulo" name="titulo" placeholder="Digite o título da tarefa">
                    </div>
                    <div class="mb-3">
                        <label for="editDescricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="editDescricao" name="descricao" placeholder="Descreva a tarefa">
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status">
                            <option value="pendente">Pendente</option>
                            <option value="em_andamento">Em Andamento</option>
                            <option value="completada">Completada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCategorias" class="form-label">Categorias</label>
                        <select class="form-control" id="editCategorias" name="categorias[]" multiple>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</div>