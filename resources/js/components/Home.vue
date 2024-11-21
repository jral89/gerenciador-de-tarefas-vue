<template>
    <div class="container-fluid px-5">
      <h2 class="mt-5">Gerenciador de Tarefas</h2>
      <div>        
        <button
          type="button"
          class="btn btn-primary"
          @click="showTaskModal"
        >
          Adicionar Tarefa
        </button>
        <button @click="logout" class="btn btn-danger">Sair</button>
      </div>
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
          <tr v-for="task in tasks" :key="task.id">
            <td>{{ task.id }}</td>
            <td>{{ task.title }}</td>
            <td>{{ task.description }}</td>
            <td>{{ task.status }}</td>
            <td>{{ task.created_at }}</td>
            <td>{{ task.updated_at }}</td>
            <td>
              {{ task.categories.map((cat, index) => 
                `${cat.title}${index < task.categories.length - 1 ? ', ' : ''}`
              ).join('') }}
            </td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                @click="confirmDelete(task.id)"
              >
                <i class="bi bi-trash"></i>
              </button>
              <button
                class="btn btn-warning btn-sm"
                @click="editTask(task)"
              >
                <i class="bi bi-pencil-fill"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  
      
      <TaskModal ref="taskModal" />
      <EditTaskModal ref="editTaskModal" />
    </div>
  </template>
  
  <script>
  import TaskModal from "../components/TaskModal.vue";
  import EditTaskModal from "../components/EditTaskModal.vue";
  
  export default {
    components: { TaskModal, EditTaskModal },
    data() {
      return {
        tasks: [], 
      };
    },
    methods: {
      loadTarefas() {
        $.ajax({
            url: "/tarefas", 
            method: "GET",
            success: (response) => {
              this.tasks = response; 
              this.$nextTick(() => {
                const table = $('#tableTarefas').DataTable();
                table.destroy();
                this.initDataTable();
            });
            },
            error: (error) => {
              Swal.fire({
                  icon: 'error',
                  title: 'Erro',
                  text: 'Ocorreu um erro ao tentar carregar as tarefas. Tente novamente.',
                  confirmButtonText: 'Ok'
              });
            }
        });
      },
      initDataTable() {
        this.$nextTick(() => {
          $('#tableTarefas').DataTable({
            language: {
              url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/pt-BR.json"
            },
            destroy: true,
            pageLength: 10,
            responsive: true
          });
        });
      },
      logout() {        
        $.ajax({
          url: '/logout',
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 
          },
          success: (response) => {
              Swal.fire({
                  icon: 'success',
                  title: 'Logout realizado com sucesso!',
                  text: 'Você será redirecionado para a página de login.',
                  showConfirmButton: true,
                  timer: 1500
              }).then(() => {
                  window.location.href = '/login'; 
              });
            },
          error: (error) => {
            Swal.fire({
                  icon: 'error',
                  title: 'Erro',
                  text: 'Ocorreu um erro ao tentar fazer logout. Tente novamente.',
                  confirmButtonText: 'Ok'
              });
          }
        });
      },
      showTaskModal() {
        this.$refs.taskModal.open();
      },
      confirmDelete(taskId) {
        Swal.fire({
            title: 'Tem certeza que deseja excluir esta tarefa?',
            text: "Esta ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
              
                $.ajax({
                    url: "/tarefas-destroy", 
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { id: taskId },
                    success: (response) => {
                      
                        Swal.fire({
                            icon: 'success',
                            title: 'Tarefa excluída!',
                            text: 'A tarefa foi excluída com sucesso.',
                            showConfirmButton: true,
                            timer: 1500
                        });

                        const table = $('#tableTarefas').DataTable();

                        table.row(function(idx, data, node) {
                            return data[0] == taskId;
                        }).remove().draw();
                    },
                    error: (error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao excluir',
                            text: 'Ocorreu um erro ao tentar excluir a tarefa. Tente novamente.',
                            confirmButtonText: 'Ok'
                        });
                        console.error("Erro ao excluir:", error);
                    }
                });
            }
        });
      },
      editTask(task) {
        this.$refs.editTaskModal.open(task);
      },
    },
    mounted() {
      this.loadTarefas(); 
    },
  };
  </script>