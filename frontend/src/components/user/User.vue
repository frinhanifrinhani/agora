<template>
  <div class="user-list">
    <h2 class="mb-4">Lista de Usuários</h2>
    
    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div v-else>
      <table class="table table-striped table-hover table-bordered">
        <thead>
          <tr class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in tableUser.data" :key="index" class="align-middle">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import UserService from '@/service/UserService';

export default {
  name: 'User',
  data() {
    return {
      tableUser: {
        data: [],
        current_page: 1,
        last_page: 1
      },
      isLoading: false,
    };
  },
  created() {
    this.UserService = new UserService();
  },
  mounted() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        this.isLoading = true;
        const response = await this.UserService.fetchUsers();

        if (response) {
          this.tableUser = {
            data: response.data.map(user => ({
              ...user,
              body: user.body
            })),
            current_page: response.current_page,
            last_page: response.last_page
          };
        }

      } catch (error) {
        console.error('Erro ao buscar usuários:', error);
      } finally {
        this.isLoading = false;
      }
    }
  },
};
</script>

<style scoped>
.user-list {
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
}

.table {
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
  padding: 12px 15px;
  vertical-align: middle;
}

.table-hover tbody tr:hover {
  background-color: #f1f1f1;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-dark {
  background-color: #343a40;
  color: #fff;
}

.table-dark th {
  border-bottom: 2px solid #454d55;
}
</style>
