<template>
  <div class="card p-4">
    <h2 class="card-title text-center mb-4">Lista de Departamentos</h2>
    <p v-if="loading" class="text-info text-center">Carregando departamentos...</p>
    <p v-else-if="error" class="text-danger text-center">Erro: {{ error }}</p>
    <div v-else-if="departments.length" class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="department in departments" :key="department.id">
            <td>{{ department.id }}</td>
            <td>{{ department.name }}</td>
            <td>
              <button @click="$emit('edit-department', department.id)" :disabled="loading" class="btn btn-sm btn-warning me-2">Editar</button>
              <button @click="$emit('delete-department', department.id)" :disabled="loading" class="btn btn-sm btn-danger">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <p v-else class="text-center">Nenhum departamento encontrado.</p>
  </div>
</template>

<script>
import api from '../../services/api';

export default {
  name: 'ListDepartments',
  data() {
    return {
      departments: [],
      loading: true,
      error: null,
    };
  },
  created() {
    this.fetchDepartments();
  },
  methods: {
    fetchDepartments() {
      this.loading = true;
      this.error = null;
      api.get('/departments')
        .then(response => {
          this.departments = response.data;
        })
        .catch(error => {
          this.error = 'Erro ao buscar departamentos: ' + (error.response && error.response.data && error.response.data.message ? error.response.data.message : error.message);
          console.error('Erro ao buscar departamentos:', error);
        }) .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
/* Remova o CSS antigo que será substituído pelo Bootstrap */
</style>