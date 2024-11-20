<template>
  <div>
    <div
      class="modal fade show d-block"
      tabindex="-1"
      aria-labelledby="editTaskModalLabel"
      aria-hidden="true"
      v-if="isVisible"
      ref="editTaskModal"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editTaskModalLabel">Editar Tarefa</h5>
            <button
              type="button"
              class="btn-close"
              @click="close"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <input type="hidden" v-model="form.id" name="id">
              
              <div class="mb-3">
                <label for="editTitulo" class="form-label">Título</label>
                <input
                  type="text"
                  class="form-control"
                  id="editTitulo"
                  v-model="form.titulo"
                  name="titulo"
                  placeholder="Digite o título da tarefa"
                />
              </div>

              <div class="mb-3">
                <label for="editDescricao" class="form-label">Descrição</label>
                <input
                  type="text"
                  class="form-control"
                  id="editDescricao"
                  v-model="form.descricao"
                  name="descricao"
                  placeholder="Descreva a tarefa"
                />
              </div>

              <div class="mb-3">
                <label for="editStatus" class="form-label">Status</label>
                <select
                  class="form-control"
                  id="editStatus"
                  v-model="form.status"
                  name="status"
                >
                  <option value="pendente">Pendente</option>
                  <option value="em_andamento">Em Andamento</option>
                  <option value="completada">Completada</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="editCategorias" class="form-label">Categorias</label>
                <select
                  class="form-control"
                  id="editCategorias"
                  v-model="form.categorias"
                  name="categorias[]"
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

              <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isVisible: false,
      categorias: [], 
      form: {
        id: null,
        titulo: "",
        descricao: "",
        status: "pendente",
        categorias: [],
      },
    };
  },
  created() {
    
    $.ajax({
      url: '/categorias',
      type: 'GET',
      success: (response) => {
        this.categorias = response;
      },
      error: (error) => {
        console.error("Erro ao carregar categorias:", error);
      }
    });
  },
  methods: {
    
    open(task) {   
      
      this.form.id = task.id;
      this.form.titulo = task.title;
      this.form.descricao = task.description;
      this.form.status = task.status;

      this.form.categorias = task.categories ? task.categories.map(categoria => categoria.id) : [];
      
      this.isVisible = true;
    },
    close() {
      this.isVisible = false;
    },
    submitForm() {
      
      $.ajax({
            url: "/tarefas-update", 
            method: "PUT",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: this.form,
            success: (response) => {
              this.close();
              this.resetForm();
            },
            error: (error) => {
              console.error("Erro ao atualizar:", error);
            }
        });
        
      this.close();
    },
    resetForm() {
      this.form = { title: '', description: '', status: '', categorias: [] };
    },
  },
};
</script>