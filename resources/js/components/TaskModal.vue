<template>
  <div>
    <div
      class="modal fade show d-block"
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
              window.location.href = '/home'; 
            },
            error: (error) => {
              console.error("Erro ao carregar categorias:", error);
            }
        });
      },
    },
    mounted() {
      this.loadCategorias(); 
    },
  };
</script>
