<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Tags</span>
      </li>
    </ol>
  </nav>
  <div class="list">
    <div class="top-list">
      <h2 class="mb-4">Tags</h2>
      <a href="/admin/tags/create" class="btn btn-primary">Cadastrar Tag</a>
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
            <th class="text-column-table-template">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(tag, index) in tableTag.data"
            :key="index"
            class="align-middle"
          >
            <td class="text-black-50">{{ tag.id }}</td>
            <td class="text-black-50">{{ truncateText(tag.name) }}</td>
           
            <td>
              <button
                class="btn btn-primary btn-sm me-2"
                @click="viewTag(tag.id)"
              >
                <i class="fa-regular fa-eye"></i>
              </button>
              <button
                class="btn btn-warning btn-sm me-2"
                @click="editTag(tag.id)"
              >
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm" @click="deleteTag(tag.id)">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :currentPage="tableTag.current_page"
        :totalPages="tableTag.last_page"
        @page-changed="changePage"
      />
    </div>
  </div>
</template>

<script>
import TagAdminService from "@/service/admin/TagAdminService";
import Pagination from "../../Pagination.vue";

export default {
  name: "TagAdmin",
  components: {
    Pagination,
  },
  data() {
    return {
      tableTag: {
        data: [],
        current_page: 1,
        last_page: 1,
      },
      isLoading: false,
    };
  },
  created() {
    this.TagAdminService = new TagAdminService();
  },
  mounted() {
    this.getTag();
  },
  methods: {
    truncateText(text) {
      if (text) {
        const maxLength = 100;
        return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
      }
    },

    async getTag(page = 1) {
      try {
        this.isLoading = true;
        const response = await this.TagAdminService.getIndexTag(this.perPage, page);

        if (response) {
          this.tableTag = {
            data: response.data.map((tag) => ({
              ...tag,
            })),
            current_page: response.current_page,
            last_page: response.last_page,
          };
        }

        this.isLoading = false;
      } catch (error) {
        console.error('Erro ao buscar tag:', error);
      } finally {
        this.isLoading = false;
      }
    },

    changePage(page) {
      if (page > 0 && page <= this.tableTag.last_page) {
        this.getTag(page);
      }
    },
  },
};
</script>

<style scoped>
.list {
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
