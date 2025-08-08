<template>
  <div class="item-manager">
    <h1>Gerenciador de Itens</h1>

    <form @submit.prevent="saveItem" class="item-form">
      <input type="text" v-model="currentItem.name" placeholder="Nome do Item" required />
      <input type="number" v-model.number="currentItem.quantity" placeholder="Quantidade" required />
      <button type="submit">{{ isEditing ? 'Atualizar Item' : 'Adicionar Item' }}</button>
      <button type="button" @click="cancelEdit" v-if="isEditing">Cancelar</button>
    </form>

    <ul class="item-list">
      <li v-for="item in items" :key="item.id">
        <span>{{ item.name }} ({{ item.quantity }})</span>
        <div>
          <button @click="editItem(item)">Editar</button>
          <button @click="deleteItem(item.id)">Excluir</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'ItemManager',
  data() {
    return {
      items: [],
      currentItem: { id: null, name: '', quantity: 0 },
      isEditing: false,
      nextId: 1,
    };
  },
  methods: {
    saveItem() {
      if (this.isEditing) {
        const index = this.items.findIndex(item => item.id === this.currentItem.id);
        if (index !== -1) {
          this.items.splice(index, 1, { ...this.currentItem });
        }
      } else {
        this.currentItem.id = this.nextId++;
        this.items.push({ ...this.currentItem });
      }
      this.resetForm();
    },
    editItem(item) {
      this.currentItem = { ...item };
      this.isEditing = true;
    },
    deleteItem(id) {
      this.items = this.items.filter(item => item.id !== id);
      if (this.currentItem.id === id) {
        this.resetForm();
      }
    },
    cancelEdit() {
      this.resetForm();
    },
    resetForm() {
      this.currentItem = { id: null, name: '', quantity: 0 };
      this.isEditing = false;
    },
  },
};
</script>

<style scoped>
.item-manager {
  max-width: 600px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #eee;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}

.item-form {
  display: flex;
  gap: 10px;
  margin-bottom: 30px;
}

.item-form input {
  flex-grow: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.item-form button {
  padding: 10px 15px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.item-form button:hover {
  background-color: #45a049;
}

.item-form button[type="button"] {
  background-color: #f44336;
}

.item-form button[type="button"]:hover {
  background-color: #da190b;
}

.item-list {
  list-style: none;
  padding: 0;
}

.item-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

.item-list li:last-child {
  border-bottom: none;
}

.item-list li span {
  font-size: 1.1em;
  color: #555;
}

.item-list li div button {
  margin-left: 10px;
  padding: 8px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.item-list li div button:first-child {
  background-color: #008CBA;
  color: white;
}

.item-list li div button:first-child:hover {
  background-color: #007B9E;
}

.item-list li div button:last-child {
  background-color: #f44336;
  color: white;
}

.item-list li div button:last-child:hover {
  background-color: #da190b;
}
</style>
