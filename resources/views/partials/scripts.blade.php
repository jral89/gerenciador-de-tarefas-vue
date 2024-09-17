<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    $(document).ready(function() {
        $('#exampleTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json"
            }
        });

        $('#cadastroTarefasForm').validate({
            rules: {
                titulo: {
                    required: true,
                },
                descricao: {
                    required: true,
                },
                status: {
                    required: true
                },
                'categorias[]': {
                    required: true
                }
            },
            messages: {
                titulo: {
                    required: "O título é obrigatório.",
                    minlength: "O título deve ter pelo menos 3 caracteres."
                },
                descricao: {
                    required: "A descrição é obrigatória.",
                    minlength: "A descrição deve ter pelo menos 5 caracteres."
                },
                status: {
                    required: "Por favor, selecione um status."
                },
                'categorias[]': {
                    required: "Por favor, selecione pelo menos uma categoria."
                }
            },
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            submitHandler: function(form) {
                var formData = $(form).serialize();

                $.ajax({
                    url: $('#cadastroTarefasForm').data('action'),
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Tarefa cadastrada com sucesso!',
                            icon: 'success',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                        $(form)[0].reset();
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message || 'Erro ao cadastrar tarefa';
                        Swal.fire('Erro!', errorMessage, 'error');
                    }
                });
            }
        });    
        
        $('#tableTarefas').on('click', '.btn-edit', function() {
            const taskId = $(this).data('id');
            
            $.ajax({
                url: `/show/${taskId}`,
                data: taskId,
                method: 'GET',
                success: function(task) {
                    $('#editTaskId').val(task.id);
                    $('#editTitulo').val(task.title);
                    $('#editDescricao').val(task.description);
                    $('#editStatus').val(task.status);
                    
                    $('#editCategorias').val(task.categories.map(c => c.id)).trigger('change');
                    
                    $('#editTaskModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire('Erro!', 'Não foi possível carregar os dados da tarefa.', 'error');
                }
            });
        });

        $('#editTaskForm').on('submit', function(event) {
            event.preventDefault();
            
            const formData = $(this).serialize();
            const taskId = $('#editTaskId').val();
            
            $.ajax({
                url: `/update/${taskId}`,
                data: taskId, 
                method: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Tarefa atualizada com sucesso!',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#editTaskModal').modal('hide');
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Erro ao atualizar tarefa';
                    Swal.fire('Erro!', errorMessage, 'error');
                }
            });
        });
    });

    function confirmDelete(button) {
        const taskId = $(button).data('id');

        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você não poderá reverter isso!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteTask(taskId);
            }
        });
    }

    function deleteTask(taskId) {
        $.ajax({
            url: `/destroy/${taskId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire('Sucesso!', 'Tarefa excluída com sucesso!', 'success');
        
                $('#tableTarefas').find('tr').filter(function() {
                    console.log('funcionou');
                    return $(this).find('td').first().text() == taskId;
                }).remove();
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON?.message || 'Erro ao excluir tarefa';
                Swal.fire('Erro!', errorMessage, 'error');
            }
        });
    }
    
</script>