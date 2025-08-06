<template>
  <div>
    <h2>Departments</h2>
    <ul>
      <li v-for="department in departments" :key="department.id">
        {{ department.name }}
        <button @click="editDepartment(department.id)">Edit</button>
        <button @click="deleteDepartment(department.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'TestDepartments',
  data() {
    return {
      departments: [],
    };
  },
  mounted() {
    this.fetchDepartments();
  },
  methods: {
    fetchDepartments() {
      api.get('/departments')
        .then(response => {
          this.departments = response.data;
        })
        .catch(error => {
          console.error('Error fetching departments:', error);
        });
    },
    editDepartment(id) {
      console.log('Edit department with ID:', id);
      // Implement navigation to edit page or open a modal
    },
    deleteDepartment(id) {
      console.log('Delete department with ID:', id);
      // Implement API call to delete department and then refresh the list
    },
  },
};
</script>

<style scoped>
h2 {
  color: green;
}
</style>
