<template>
  <div class="card p-4 mb-4">
    <h2 class="card-title text-center mb-4">{{ isEditing ? 'Editar Departamento' : 'Criar Departamento' }}</h2>
    <form @submit.prevent="submitForm">
      <p v-if="loading" class="text-info text-center">Carregando...</p>
      <p v-if="error" class="text-danger text-center">{{ error }}</p>
      <div class="mb-3">
        <label for="departmentName" class="form-label">Nome do Departamento:</label>
        <input type="text" id="departmentName" v-model="department.name" class="form-control" :class="{'is-invalid': errors.name}" required :disabled="loading" />
        <div v-if="errors.name" class="invalid-feedback">{{ errors.name }}</div>
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary" :disabled="loading">{{ isEditing ? 'Atualizar' : 'Criar' }}</button>
        <button type="button" @click="cancelForm" class="btn btn-secondary" :disabled="loading">Cancelar</button>
      </div>
    </form>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'DepartmentForm',
  props: {
    departmentId: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      department: {
        id: null,
        name: '',
      },
      isEditing: false,
      loading: false,
      error: null,
      errors: {},
    };
  },
  watch: {
    departmentId: {
      immediate: true,
      handler(newId) {
        if (newId) {
          this.isEditing = true;
          this.fetchDepartment(newId);
        } else {
          this.isEditing = false;
          this.department = { id: null, name: '' }; // Reset form for creation
        }
      },
    },
  },
  methods: {
    fetchDepartment(id) {
      this.loading = true;
      this.error = null;
      api.get(`/departments/${id}`)
        .then(response => {
          this.department = response.data;
        })
        .catch(error => {
          this.error = 'Erro ao buscar departamento: ' + (error.response?.data?.message || error.message);
          console.error('Erro ao buscar departamento:', error);
        }) .finally(() => {
          this.loading = false;
        });
    },
    submitForm() {
      this.loading = true;
      this.error = null;
      this.errors = {};

      if (!this.department.name) {
        this.errors.name = 'O nome do departamento é obrigatório.';
      }

      if (Object.keys(this.errors).length > 0) {
        this.loading = false;
        return;
      }

      if (this.isEditing) {
        api.put(`/departments/${this.department.id}`, this.department)
          .then(() => {
            alert('Departamento atualizado com sucesso!');
            this.$emit('form-success');
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.errors = error.response.data.errors;
            } else {
              this.error = 'Erro ao atualizar departamento: ' + (error.response?.data?.message || error.message);
            }
            console.error('Erro ao atualizar departamento:', error);
          }) .finally(() => {
            this.loading = false;
          });
      } else {
        api.post('/departments', this.department)
          .then(() => {
            alert('Departamento criado com sucesso!');
            this.$emit('form-success');
            this.department = { id: null, name: '' };
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              this.errors = error.response.data.errors;
            } else {
              this.error = 'Erro ao criar departamento: ' + (error.response && error.response.data && error.response.data.message ? error.response.data.message : error.message);
            }
            console.error('Erro ao criar departamento:', error);
          }) .finally(() => {
            this.loading = false;
          });
      }
    },
    cancelForm() {
      this.department = { id: null, name: '' };
      this.error = null;
      this.errors = {};
      this.$emit('form-cancel');
    },
  },
};
</script>

<style scoped>
/* Remova o CSS antigo que será substituído pelo Bootstrap */
</style>