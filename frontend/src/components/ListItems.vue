<template>
  <div class="card p-4">
    <h2 class="card-title text-center mb-4">Lista de Itens</h2>
    <button @click="startCreate" :disabled="loading" class="btn btn-success mb-3">Adicionar Novo Item</button>
    <p v-if="loading" class="text-info text-center">Carregando itens...</p>
    <p v-if="error" class="text-danger text-center">{{ error }}</p>
    <div class="table-responsive" v-if="!loading && !error">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Departamento</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.department ? item.department.name : 'N/A' }}</td>
            <td>
              <button @click="editItem(item)" :disabled="loading" class="btn btn-sm btn-warning me-2">Editar</button>
              <button @click="deleteItem(item.id)" :disabled="loading" class="btn btn-sm btn-danger">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <p v-else-if="!loading && !error && items.length === 0" class="text-center">Nenhum item encontrado.</p>

    <ItemForm
      v-if="showForm"
      :itemToEdit="selectedItem"
      @item-saved="handleItemSaved"
      @cancel-edit="cancelEdit"
    />
  </div>
</template>

<script>
import axios from 'axios';
import ItemForm from './ItemForm.vue';

export default {
  components: {
    ItemForm,
  },
  data() {
    return {
      items: [],
      showForm: false,
      selectedItem: null,
      loading: false,
      error: null,
    };
  },
  created() {
    this.fetchItems();
  },
  methods: {
    async fetchItems() {
      this.loading = true;
      this.error = null;
      try {
        const response = await axios.get('/api/items');
        this.items = response.data;
      } catch (error) {
        this.error = 'Erro ao buscar itens: ' + (error.response?.data?.message || error.message);
        console.error('Erro ao buscar itens:', error);
      } finally {
        this.loading = false;
      }
    },
    startCreate() {
      this.selectedItem = null;
      this.showForm = true;
    },
    editItem(item) {
      this.selectedItem = item;
      this.showForm = true;
    },
    async deleteItem(id) {
      if (confirm('Tem certeza que deseja excluir este item?')) {
        this.loading = true;
        this.error = null;
        try {
          await axios.delete(`/api/items/${id}`);
          this.fetchItems();
        } catch (error) {
          this.error = 'Erro ao excluir item: ' + (error.response && error.response.data && error.response.data.message ? error.response.data.message : error.message);
          console.error('Erro ao excluir item:', error);
        } finally {
          this.loading = false;
        }
      }
    },
    handleItemSaved() {
      this.showForm = false;
      this.fetchItems();
    },
    cancelEdit() {
      this.showForm = false;
      this.selectedItem = null;
    },
  },
};
</script>

<style scoped>
/* Remova o CSS antigo que será substituído pelo Bootstrap */
</style>
