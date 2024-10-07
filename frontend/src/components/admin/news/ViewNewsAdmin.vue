<template>
  <FlashMessage />

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Notícias / {{ news.titule }}</span>
      </li>
    </ol>
  </nav>

  <div class="content">
    <div class="top-content">
      <h2 class="mb-4">Notícias</h2>
    </div>

    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div class="view-area">
      <div class="mb-3">
        <label for="title" class="form-label">Título</label>
        <input type="text" v-model="news.id" class="form-control" disabled />
      </div>

      <div class="mb-3">
        <label for="title" class="form-label">Título</label>
        <input type="text" v-model="news.title" class="form-control" disabled />
      </div>

      <div class="mb-3">
        <label for="alias" class="form-label">Alias</label>
        <input type="text" v-model="news.alias" class="form-control" disabled />
      </div>

      <div class="mb-3">
        <label for="body" class="form-label">Notícia</label>
        <div class="body-news" v-html="news.body"></div>
      </div>

      <div class="mb-3">
        <label for="categories" class="form-label">Categorias</label>
        <div
          class="form-control form-control multi-select-view"
          v-html="concatenatedCategories"
        ></div>
      </div>

      <div class="mb-3">
        <label for="tags" class="form-label">Tags</label>
        <div
          class="form-control form-control multi-select-view"
          v-html="concatenatedTags"
        ></div>
      </div>

      <router-link to="/admin/news" class="btn btn-danger"> Cancelar </router-link>
      &nbsp;
      <a href="#" class="btn btn-primary"> Editar </a>
    </div>
  </div>
</template>

<script>
import NewsAdminService from "@/service/admin/NewsAdminService";
import { useFlashMessage } from "@/service/FlashMessageService";

export default {
  name: "ViewNewsAdmin",
  data() {
    return {
      news: {
        category: [],
        tag: [],
      },
      isLoading: false,
    };
  },
  created() {
    this.NewsAdminService = new NewsAdminService();
    this.getNews();
  },
  computed: {
    concatenatedCategories() {
      return this.news.category.map(cat => `<div class='multi-select-view-item'>${cat.name}</div>`).join('');
    },
    concatenatedTags() {
      return this.news.tag.map(cat => `<div class='multi-select-view-item'>${cat.name}</div>`).join('');
    },
  },
  setup() {
    const { setFlashMessage } = useFlashMessage();
    return { setFlashMessage };
  },
  methods: {
    async getNews() {
      const id = this.$route.params.id;

      this.loading = true;

      try {
        const response = await this.NewsAdminService.getNews(id);
        console.log(response);
        if (response && response.data) {
          this.news = response.data;
        } else {
          this.setFlashMessage(response, "error");
          this.$router.push("/admin/news");
        }
      } catch (error) {
        this.setFlashMessage(error.message, "error");
        this.$router.push("/admin/news");
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
.content {
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
}

.top-content {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
}

.top-content h2 {
  color: #5ab25e;
}

.view-area {
  padding: 25px 175px;
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.content-view-area {
  padding-bottom: 75px;
  color: rgba(0, 0, 0, 0.5) !important;
}

.content-view-line {
  display: flex;
  gap: 10px;
}

.content-view-area .label {
  font-weight: 700;
}
.body-news {
  border: 1px solid #dee2e6 !important;
  background: #e9ecef;
  border-radius: 0.375rem;
  padding: 0.375rem 0.75rem;
  min-height: 350px;
  color:rgba(0, 0, 0, 0.5) !important
}

.form-label, input{
  color:rgba(0, 0, 0, 0.5) !important
}

</style>
