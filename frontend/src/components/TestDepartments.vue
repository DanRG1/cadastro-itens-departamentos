<template>
  <div>
    <h2>Departments</h2>
    <ul>
      <li v-for="department in departments" :key="department.id">{{ department.name }}</li>
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
    api.get('/departments')
      .then(response => {
        this.departments = response.data;
      })
      .catch(error => {
        console.error('Error fetching departments:', error);
      });
  },
};
</script>

<style scoped>
h2 {
  color: green;
}
</style>
