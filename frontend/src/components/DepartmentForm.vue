<template>
  <div>
    <h2>{{ isEditing ? 'Edit Department' : 'Create Department' }}</h2>
    <form @submit.prevent="submitForm">
      <div>
        <label for="departmentName">Department Name:</label>
        <input type="text" id="departmentName" v-model="department.name" required />
      </div>
      <button type="submit">{{ isEditing ? 'Update' : 'Create' }}</button>
      <button type="button" @click="cancelForm">Cancel</button>
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
      api.get(`/departments/${id}`)
        .then(response => {
          this.department = response.data;
        })
        .catch(error => {
          console.error('Error fetching department:', error);
        });
    },
    submitForm() {
      if (this.isEditing) {
        api.put(`/departments/${this.department.id}`, this.department)
          .then(() => {
            alert('Department updated successfully!');
            this.$emit('form-success');
          })
          .catch(error => {
            console.error('Error updating department:', error);
          });
      } else {
        api.post('/departments', this.department)
          .then(() => {
            alert('Department created successfully!');
            this.$emit('form-success');
            this.department = { id: null, name: '' }; // Clear form after creation
          })
          .catch(error => {
            console.error('Error creating department:', error);
          });
      }
    },
    cancelForm() {
      this.$emit('form-cancel');
    },
  },
};
</script>

<style scoped>
div {
  margin-bottom: 1rem;
}
label {
  display: block;
  margin-bottom: 0.5rem;
}
input[type="text"] {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
button {
  padding: 0.75rem 1.5rem;
  margin-right: 0.5rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  background-color: #007bff;
  color: white;
}
button[type="button"] {
  background-color: #6c757d;
}
</style>