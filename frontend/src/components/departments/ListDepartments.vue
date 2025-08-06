<template>
  <div>
    <h2>Departments List</h2>
    <p v-if="loading">Loading departments...</p>
    <p v-else-if="error">Error: {{ error }}</p>
    <ul v-else-if="departments.length">
      <li v-for="department in departments" :key="department.id">{{ department.name }}</li>
    </ul>
    <p v-else>No departments found.</p>
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
      api.get('/departments')
        .then(response => {
          this.departments = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching departments:', error);
          this.error = 'Failed to load departments.';
          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
h2 {
  color: #333;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  background-color: #f9f9f9;
  margin-bottom: 5px;
  padding: 8px;
  border-radius: 4px;
}
</style>
