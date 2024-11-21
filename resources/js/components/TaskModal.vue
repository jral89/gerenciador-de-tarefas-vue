<template>
  <div>
    <div
      class="modal fade show d-block"
      id="modalTarefa"
      tabindex="-1"
      aria-labelledby="taskModalLabel"
      role="dialog"
      v-if="isVisible"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Cadastro de Tarefa</h5>
            <button
              type="button"
              class="btn-close"
              @click="close"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="titulo" class="form-label">Título</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.titulo"
                    placeholder="Digite o título da tarefa"
                  />
                </div>
                <div class="col-md-6">
                  <label for="descricao" class="form-label">Descrição</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.descricao"
                    placeholder="Descreva a tarefa"
                  />
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="status" class="form-label">Status</label>
                  <select
                    class="form-control"
                    v-model="form.status"
                  >
                    <option value="pendente">Pendente</option>
                    <option value="em_andamento">Em Andamento</option>
                    <option value="completada">Completada</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="categorias" class="form-label">Categorias</label>
                  <select
                    class="form-control"
                    v-model="form.categorias"
                    multiple
                  >
                    <option
                      v-for="categoria in categorias"
                      :key="categoria.id"
                      :value="categoria.id"
                    >
                      {{ categoria.title }}
                    </option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  $.get('/csrf-token', function(response) {
      $('meta[name="csrf-token"]').attr('content', response.csrfToken);
  });
  export default {
    data() {
      return {
          isVisible: false,
          form: {
            titulo: '',
            descricao: '',
            status: '',
            categorias: [], 
          },
          categorias: [],
            };
    },
    methods: {
      loadCategorias() {
        $.ajax({
            url: "/categorias", 
            method: "GET",
            success: (response) => {
              this.categorias = response;
            },
            error: (error) => {
              console.error("Erro ao carregar categorias:", error);
            }
        });
      },
      open() {
        this.isVisible = true;
      },
      close() {
        this.isVisible = false;
      },
      submitForm() {
        $.ajax({
            url: "/tarefas/store", 
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: this.form,
            success: (response) => {

              Swal.fire({
                  icon: 'success',
                  title: 'Tarefa cadastrada!',
                  text: 'A tarefa foi cadastrada com sucesso.',
                  showConfirmButton: true,
                  timer: 1500
              });

              this.close();
              this.resetForm();
              const task = response.task; 
              
              $('#tableTarefas').DataTable().row.add([
                  task.id, 
                  task.title, 
                  task.description, 
                  task.status, 
                  task.created_at, 
                  task.updated_at, 
                  task.categories.map(cat => cat.title).join(', '), 
                  `
                  <button class="btn btn-danger btn-sm" onclick="confirmDelete(${task.id})">
                      <i class="bi bi-trash"></i>
                  </button>
                  <button class="btn btn-warning btn-sm" onclick="editTask(${task.id})">
                      <i class="bi bi-pencil-fill"></i>
                  </button>
                  `
              ]).draw(false);
            },
            error: (error) => {
              Swal.fire({
                  icon: 'error',
                  title: 'Erro',
                  text: 'Ocorreu um erro ao tentar cadastrar a tarefa. Tente novamente.',
                  confirmButtonText: 'Ok'
              });
            }
        });
      }, 
      resetForm() {
        this.form = { title: '', description: '', status: '', categorias: [] };
      },
    },
    mounted() {
      this.loadCategorias(); 
    },
  };
</script>
