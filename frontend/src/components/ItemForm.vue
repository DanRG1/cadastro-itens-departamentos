<template>
  <div class="card p-4 mb-4">
    <h2 class="card-title text-center mb-4">{{ isEditing ? 'Editar Item' : 'Criar Novo Item' }}</h2>
    <form @submit.prevent="submitForm">
      <p v-if="loading" class="text-info text-center">Carregando...</p>
      <p v-if="error" class="text-danger text-center">{{ error }}</p>
      <div class="mb-3">
        <label for="name" class="form-label">Nome:</label>
        <input type="text" id="name" v-model="item.name" class="form-control" :class="{'is-invalid': errors.name}" required />
        <div v-if="errors.name" class="invalid-feedback">{{ errors.name }}</div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Descrição:</label>
        <textarea id="description" v-model="item.description" class="form-control" :class="{'is-invalid': errors.description}" required></textarea>
        <div v-if="errors.description" class="invalid-feedback">{{ errors.description }}</div>
      </div>
      <div class="mb-3">
        <label for="department" class="form-label">Departamento:</label>
        <select id="department" v-model="item.department_id" class="form-select" :class="{'is-invalid': errors.department_id}" required>
          <option value="">Selecione um Departamento</option>
          <option v-for="department in departments" :key="department.id" :value="department.id">
            {{ department.name }}
          </option>
        </select>
        <div v-if="errors.department_id" class="invalid-feedback">{{ errors.department_id }}</div>
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary" :disabled="loading">{{ isEditing ? 'Atualizar' : 'Criar' }} Item</button>
        <button type="button" @click="cancel" class="btn btn-secondary" :disabled="loading">Cancelar</button>
      </div>
    </form>
  </div>
</template>

<style scoped>
/* Remova o CSS antigo que será substituído pelo Bootstrap */
</style>

<script>
import axios from 'axios';

export default {
  props: {
    itemToEdit: { // Propriedade para receber o item a ser editado
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      item: {
        name: '',
        description: '',
        department_id: '',
      },
      departments: [],
      isEditing: false,
      loading: false,
      error: null,
      errors: {},
    };
  },
  watch: {
    itemToEdit: {
      handler(newItem) {
        if (newItem) {
          this.item = { ...newItem };
          this.isEditing = true;
        } else {
          this.resetForm();
          this.isEditing = false;
        }
      },
      immediate: true, // Executa o handler imediatamente na montagem do componente
    },
  },
  created() {
    this.fetchDepartments();
  },
  methods: {
    async fetchDepartments() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get('/api/departments');
        this.departments = response.data;
      } catch (error) {
        this.error = 'Erro ao buscar departamentos: ' + (error.response?.data?.message || error.message);
        console.error('Erro ao buscar departamentos:', error);
      } finally {
        this.loading = false;
      }
    },
    async submitForm() {
      this.loading = true;
      this.error = null;
      this.errors = {}; // Limpa erros anteriores

      // Validação básica no cliente
      if (!this.item.name) {
        this.errors.name = 'O nome é obrigatório.';
      }
      if (!this.item.description) {
        this.errors.description = 'A descrição é obrigatória.';
      }
      if (!this.item.department_id) {
        this.errors.department_id = 'O departamento é obrigatório.';
      }

      if (Object.keys(this.errors).length > 0) {
        this.loading = false;
        return; // Impede o envio se houver erros de validação
      }

      try {
        if (this.isEditing) {
          await axios.put(`/api/items/${this.item.id}`, this.item);
        } else {
          await axios.post('/api/items', this.item);
        }
        this.$emit('item-saved');
        this.resetForm();
      } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          this.error = 'Erro ao salvar item: ' + (error.response && error.response.data && error.response.data.message ? error.response.data.message : error.message);
        }
        console.error('Erro ao salvar item:', error);
      } finally {
        this.loading = false;
      }
    },
    cancel() {
      this.resetForm();
      this.$emit('cancel-edit');
    },
    resetForm() {
      this.item = {
        name: '',
        description: '',
        department_id: '',
      };
      this.error = null;
      this.errors = {};
    },
  },
};
</script>

<style scoped>
/* Adicione seu CSS aqui */
</style>
