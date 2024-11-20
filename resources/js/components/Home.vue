<template>
    <div class="container-fluid px-5">
      <h2 class="mt-5">Gerenciador de Tarefas</h2>
      <button
        type="button"
        class="btn btn-primary"
        @click="showTaskModal"
      >
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
  
      <!-- Modais -->
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
        tasks: [], // Aqui você pode carregar os dados via API
      };
    },
    methods: {
      loadTarefas() {
        $.ajax({
            url: "/tarefas", // URL definida na rota Laravel
            method: "GET",
            success: (response) => {
              console.log(response);
              this.tasks = response; // Atualiza a lista com os dados recebidos
            },
            error: (error) => {
              console.error("Erro ao carregar categorias:", error);
            }
        });
      },
      showTaskModal() {
        this.$refs.taskModal.open();
      },
      confirmDelete(taskId) {
        // Lógica para confirmar exclusão
        console.log("Excluir tarefa", taskId);
      },
      editTask(task) {
        this.$refs.editTaskModal.open(task);
      },
    },
    mounted() {
      this.loadTarefas(); // Chama a função assim que o componente é montado
    },
  };
  </script>