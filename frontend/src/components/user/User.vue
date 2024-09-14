<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><span class="text-black-50">Home / Usuários</span></li>
    </ol>
  </nav>
  <div class="user-list">
    <h2 class="mb-4">Usuários</h2>    
    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div v-else>
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="text-column-table-template">ID</th>
            <th class="text-column-table-template">Nome</th>
            <th class="text-column-table-template">Email</th>
            <th class="text-column-table-template">Açao</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in tableUser.data" :key="index" class="align-middle">
            <td class="text-black-50">{{ user.id }}</td>
            <td class="text-black-50">{{ user.name }}</td>
            <td class="text-black-50">{{ user.email }}</td>
            <td>
              <button class="btn btn-primary btn-sm me-2" @click="viewUser(user.id)"><i class="fa-regular fa-eye"></i></button>
              <button class="btn btn-warning btn-sm me-2" @click="editUser(user.id)"><i class="fa-regular fa-pen-to-square"></i></button>
              <button class="btn btn-danger btn-sm" @click="deleteUser(user.id)"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
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

.text-column-table-template {
  color: #5ab25e;
  font-weight: 400;  
}
</style>
