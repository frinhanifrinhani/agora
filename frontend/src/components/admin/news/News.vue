<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Notícias</span>
      </li>
    </ol>
  </nav>
  <div class="news-list">
    <div class="top-list">
      <h2 class="mb-4">Notícias</h2>
      <a href="#" class="btn btn-primary">Cadastrar Notícia</a>
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
            <th class="text-column-table-template">Título</th>
            <th class="text-column-table-template">Status</th>
            <th class="text-column-table-template">Publicar/Despublicar</th>
            <th class="text-column-table-template">Data de criação</th>
            <th class="text-column-table-template">Data de publicação</th>
            <th class="text-column-table-template">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(news, index) in tableNews.data" :key="index" class="align-middle">
            <td class="text-black-50">{{ news.id }}</td>
            <td class="text-black-50">{{ truncateTitle(news.title) }}</td>
            <td class="text-black-50">
              {{ publicationStatus(news.publicated) }}
            </td>
            <td class="text-black-50 center">
              <button
                v-if="!news.publicated"
                class="btn btn-primary btn-sm me-2"
                @click="publishNews(news.id)"
              >
                <i class="fa-regular fa-circle-check"></i>
              </button>
              <button
                v-if="news.publicated"
                class="btn btn-danger btn-sm me-2"
                @click="unpublishNews(news.id)"
              >
                <i class="fa-regular fa-circle-xmark"></i>
              </button>
            </td>
            <td class="text-black-50">{{ news.created_at }}</td>
            <td class="text-black-50">{{ news.publication_date }}</td>
            <td>
              <button class="btn btn-primary btn-sm me-2" @click="viewNews(news.id)">
                <i class="fa-regular fa-eye"></i>
              </button>
              <button class="btn btn-warning btn-sm me-2" @click="editNews(news.id)">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm" @click="deleteNews(news.id)">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :currentPage="tableNews.current_page"
        :totalPages="tableNews.last_page"
        @page-changed="changePage"
      />
    </div>
  </div>
</template>

<script>
import NewsService from "@/service/admin/NewsService";
import Pagination from "../../Pagination.vue";

export default {
  name: "News",
  components: {
    Pagination,
  },
  data() {
    return {
      tableNews: {
        data: [],
        current_page: 1,
        last_page: 1,
      },
      isLoading: false,
    };
  },
  created() {
    this.NewsService = new NewsService();
  },
  mounted() {
    this.getNews();
  },
  methods: {
    truncateTitle(title) {
      const maxLength = 90;
      return title.length > maxLength ? title.substring(0, maxLength) + "..." : title;
    },

    publicationStatus(status) {
      let statusToShow = "Não publicado";

      if (status) {
        statusToShow = "Publicado";
      }

      return statusToShow;
    },

    publishNews(id) {
      console.log(id);
    },

    async unpublishNews(id) {
      //this.loading = true;
      const response = await this.NewsService.getIndexNews(this.perPage, page);
      console.log(id);
    },

    async getNews(page = 1) {
      this.loading = true;
      const response = await this.NewsService.getIndexNews(this.perPage, page);

      if (response) {
        this.tableNews = {
          data: response.data.map((news) => ({
            ...news,
          })),
          current_page: response.current_page,
          last_page: response.last_page,
        };
      }

      this.loading = false;
    },
    changePage(page) {
      if (page > 0 && page <= this.tableNews.last_page) {
        this.getNews(page);
      }
    },
  },
};
</script>

<style scoped>
.news-list {
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

.center {
  text-align: center;
}
</style>
