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
      <router-link to="/admin/news/create" class="btn btn-primary">
        Cadastrar Notícia
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
            <td class="text-black-50">{{ truncateText(news.title) }}</td>
            <td class="text-black-50">
              {{ publicationStatus(news.publicated) }}
            </td>
            <td class="text-black-50 center">
              <ConfirmUnpublish
                v-if="news.publicated"
                :confirmationMessage="'Deseja realmente despublicar esta Notícia?'"
                :itemType="'A Notícia'"
                :itemName="news.title"
                :successMessage="news.title + ' foi despublicada com sucesso.'"
                @confirmed="unpublishNews(news.id)"
                :refreshList="true"
              />

              <ConfirmPublish
                v-if="!news.publicated"
                :confirmationMessage="'Deseja realmente publicar esta Notícia?'"
                :itemType="'A Notícia'"
                :itemName="news.title"
                :successMessage="news.title + ' foi publicada com sucesso.'"
                @confirmed="publishNews(news.id)"
                :refreshList="true"
              />
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
              <ConfirmDelete
                :confirmationMessage="'Deseja realmente deletar esta Notícia?'"
                :confirmationText="'Esta ação não pode ser desfeita para a Notícia:'"
                :itemType="'A Notícia'"
                :itemName="news.name"
                :successMessage="news.name + ' foi deletada com sucesso.'"
                @confirmed="deleteNews(news.id)"
                :refreshList="true"
              />
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
import NewsAdminService from "@/service/admin/NewsAdminService";
import Pagination from "../../Pagination.vue";
import ConfirmDelete from "../ConfirmDelete.vue";
import ConfirmPublish from "../ConfirmPublish.vue";
import ConfirmUnpublish from "../ConfirmUnpublish.vue";

export default {
  name: "NewsAdmin",
  components: {
    Pagination,
    ConfirmDelete,
    ConfirmPublish,
    ConfirmUnpublish,
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
    this.NewsAdminService = new NewsAdminService();
  },
  mounted() {
    this.fetchNews();
  },
  methods: {
    truncateText(text) {
      if (text) {
        const maxLength = 90;
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

    async fetchNews(page = 1) {
      try {
        this.isLoading = true;
        const response = await this.NewsAdminService.getIndexNews(this.perPage, page);

        if (response) {
          this.tableNews = {
            data: response.data.map((news) => ({
              ...news,
            })),
            current_page: response.current_page,
            last_page: response.last_page,
          };
        }

        this.isLoading = false;
      } catch (error) {
        console.error("Erro ao buscar notícias:", error);
      } finally {
        this.isLoading = false;
      }
    },

    viewNews(id) {
      this.$router.push({ name: "ViewNewsAdmin", params: { id: id } });
    },

    async deleteNews(id) {
      try {
        await this.NewsAdminService.deleteNews(id);

        await this.fetchNews();
      } catch (error) {
        this.setFlashMessage(error, "error");
      }
    },

    async publishNews(id) {
      try {
        await this.NewsAdminService.publishNews(id);

        await this.fetchNews();
      } catch (error) {
        this.setFlashMessage(error, "error");
      }
    },

    async unpublishNews(id) {
      try {
        await this.NewsAdminService.unpublishNews(id);

        await this.fetchNews();
      } catch (error) {
        this.setFlashMessage(error, "error");
      }
    },

    changePage(page) {
      if (page > 0 && page <= this.tableNews.last_page) {
        this.fetchNews(page);
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

/* .center {
  text-align: center;
} */
</style>
