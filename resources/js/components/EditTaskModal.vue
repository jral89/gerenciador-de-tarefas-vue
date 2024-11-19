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
  export default {
    data() {
      return {
        isVisible: false,
        categorias: [], // Aqui você pode carregar os dados via API
        form: {
          titulo: "",
          descricao: "",
          status: "pendente",
          categorias: [],
        },
      };
    },
    methods: {
      open() {
        this.isVisible = true;
      },
      close() {
        this.isVisible = false;
      },
      submitForm() {
        // Lógica para envio do formulário
        console.log(this.form);
        this.close();
      },
    },
  };
  </script>
  