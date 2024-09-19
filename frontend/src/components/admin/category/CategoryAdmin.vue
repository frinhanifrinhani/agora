<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Categorias</span>
      </li>
    </ol>
  </nav>
  <div class="category-list">
    <div class="top-list">
      <h2 class="mb-4">Categorias</h2>
            <router-link to="/admin/categories/create" class="btn btn-primary">
        Cadastrar Categoria
      </router-link>
    </div>

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
            <th class="text-column-table-template">Descrição</th>
            <th class="text-column-table-template">Status</th>
            <th class="text-column-table-template">Publicar/Despublicar</th>
            <th class="text-column-table-template">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(category, index) in tableCategory.data"
            :key="index"
            class="align-middle"
          >
            <td class="text-black-50">{{ category.id }}</td>
            <td class="text-black-50">{{ truncateText(category.name) }}</td>
            <td class="text-black-50">{{ truncateText(category.description) }}</td>
            <td class="text-black-50">
              {{ publicationStatus(category.status) }}
            </td>
            <td class="text-black-50 center">
              <button
                v-if="!category.status"
                class="btn btn-primary btn-sm me-2"
                @click="publishCategory(category.id)"
              >
                <i class="fa-regular fa-circle-check"></i>
              </button>
              <button
                v-if="category.status"
                class="btn btn-danger btn-sm me-2"
                @click="unpublishCategory(category.id)"
              >
                <i class="fa-regular fa-circle-xmark"></i>
              </button>
            </td>
            <td>
              <button
                class="btn btn-primary btn-sm me-2"
                @click="viewCategory(category.id)"
              >
                <i class="fa-regular fa-eye"></i>
              </button>
              <button
                class="btn btn-warning btn-sm me-2"
                @click="editCategory(category.id)"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm" @click="deleteCategory(category.id)">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :currentPage="tableCategory.current_page"
        :totalPages="tableCategory.last_page"
        @page-changed="changePage"
      />
    </div>
  </div>
</template>

<script>
import CategoryAdminService from "@/service/admin/CategoryAdminService";
import Pagination from "../../Pagination.vue";

export default {
  name: "CategoryAdmin",
  components: {
    Pagination,
  },
  data() {
    return {
      tableCategory: {
        data: [],
        current_page: 1,
        last_page: 1,
      },
      isLoading: false,
    };
  },
  created() {
    this.CategoryAdminService = new CategoryAdminService();
  },
  mounted() {
    this.getCategory();
  },
  methods: {
    truncateText(text) {
      if (text) {
        const maxLength = 100;
        return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
      }
    },

    publicationStatus(status) {
      let statusToShow = "Não publicado";

      if (status) {
        statusToShow = "Publicado";
      }

      return statusToShow;
    },

    async getCategory(page = 1) {
      try {
        this.isLoading = true;
        const response = await this.CategoryAdminService.getIndexCategory(this.perPage, page);

        if (response) {
          this.tableCategory = {
            data: response.data.map((category) => ({
              ...category,
            })),
            current_page: response.current_page,
            last_page: response.last_page,
          };
        }

        this.isLoading = false;
      } catch (error) {
        console.error('Erro ao buscar categorias:', error);
      } finally {
        this.isLoading = false;
      }
    },

    changePage(page) {
      if (page > 0 && page <= this.tableCategory.last_page) {
        this.getCategory(page);
      }
    },
  },
};
</script>

<style scoped>
.category-list {
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
}

.top-list {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
}

.top-list h2 {
  color: #5ab25e;
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

/* .center {
  text-align: center;
} */
</style>
