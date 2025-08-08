<script>
import DepartmentForm from './components/DepartmentForm.vue';
import ListDepartments from './components/departments/ListDepartments.vue';
import ListItems from './components/ListItems.vue'; // Importe o componente ListItems
import api from './services/api'; // Importe a instância da API

export default {
  name: 'App',
  components: {
    DepartmentForm,
    ListDepartments,
    ListItems, // Adicione ListItems aos componentes
  },
  data() {
    return {
      showDepartmentForm: false,
      selectedDepartmentId: null,
    };
  },
  methods: {
    showCreateForm() {
      this.selectedDepartmentId = null;
      this.showDepartmentForm = true;
    },
    showEditForm(id) {
      this.selectedDepartmentId = id;
      this.showDepartmentForm = true;
    },
    handleFormSuccess() {
      this.showDepartmentForm = false;
      // Força a atualização da lista de departamentos
      this.$refs.departmentList.fetchDepartments();
    },
    handleFormCancel() {
      this.showDepartmentForm = false;
    },
    async handleDeleteDepartment(id) {
      if (confirm('Tem certeza que deseja deletar este departamento?')) {
        try {
          await api.delete(`/departments/${id}`);
          alert('Departamento deletado com sucesso!');
          this.$refs.departmentList.fetchDepartments(); // Recarrega a lista
        } catch (error) {
          console.error('Erro ao deletar departamento:', error);
          alert('Falha ao deletar departamento.');
        }
      }
    },
  },
};
</script>

<template>
  <div id="app" class="container mt-5">
    <h1 class="mb-4">Gerenciamento de Departamentos</h1>

    <button v-if="!showDepartmentForm" @click="showCreateForm" class="btn btn-primary mb-3">Adicionar Novo Departamento</button>

    <DepartmentForm
      v-if="showDepartmentForm"
      :departmentId="selectedDepartmentId"
      @form-success="handleFormSuccess"
      @form-cancel="handleFormCancel"
    />

    <ListDepartments
      v-else
      ref="departmentList"
      @edit-department="showEditForm"
      @delete-department="handleDeleteDepartment"
    />

    <hr class="my-5">

    <h1 class="mb-4">Gerenciamento de Itens</h1>
    <ListItems />
  </div>
</template>

<style>
/* Remova o CSS antigo que será substituído pelo Bootstrap */
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>