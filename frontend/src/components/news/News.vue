<template>
  <div>
    <div v-if="loading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div v-else>
      <div class="row justify-content-center">
        <div class="col-md-8 align-items-center">
          <div class="p-4 text-center">
            <p class="h2">Notícias</p>
          </div>
        </div>
      </div>

      <div class="row justify-content-center pb-3">
        <div v-for="(news, index) in tableNews.data" :key="index"
          class="col-lg-5 col-md-5 mb-3 d-flex justify-content-center"
        >
          <div class="p-1">
            <div class="card pb-4" style="width: 33rem; height: auto !important;">
              <ImageComponent 
                v-if="news.files_news && news.files_news.length > 0" 
                :imagePath="news.files_news[0].file.full_path" 
              />
              <div v-else class="no-image">
                <p></p>
              </div>
              <div class="card-body">
                <div class="pb-1">
                  <h5 class="card-title text-truncate" style="max-width: 100%;">
                    <a href="#" target="_blank" rel="noopener noreferrer">
                      <strong>{{ news.title }}</strong>
                    </a>
                  </h5>
                </div>
                <div class="card-text-container mb-4">
                  <p class="card-text" v-html="news.body"></p>
                </div>
                <div class="card-info-area mb-0">
                  <div class="card-info">
                    <small>
                      <i class="fas fa-calendar-alt"></i>
                      <FormattedDate :date="news.publication_date" />
                    </small>
                  </div>
                  <a class="btn btn-sm float-end" href="#">
                    <small class="text-white">MAIS</small>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <Pagination
        :currentPage="tableNews.current_page"
        :totalPages="tableNews.last_page"
        @page-changed="changePage"
      />
    </div>
  </div>
</template>

<script>
import NewsService from '../../service/NewsService';
import DOMPurify from 'dompurify';
import FormattedDate from '../FormattedDate.vue';
import Pagination from '../Pagination.vue';
import ImageComponent from '../ImageComponent.vue';

export default {
  name: "News",
  components: {
    FormattedDate,
    Pagination,
    ImageComponent,
  },
  data() {
    return {
      tableNews: {
        data: [],
        current_page: 1,
        last_page: 1
      },
      loading: false
    };
  },
  created() {
    this.NewsService = new NewsService();
  },
  mounted() {
    this.getNews();
  },
  methods: {
    async getNews(page = 1) {
      this.loading = true;
      const response = await this.NewsService.getIndexNews(this.perPage, page);
      
      if (response) {
        this.tableNews = {
          data: response.data.map(news => ({
            ...news,
            body: DOMPurify.sanitize(news.body)
          })),
          current_page: response.current_page,
          last_page: response.last_page
        };
      }

      this.loading = false;
    },
    changePage(page) {
      if (page > 0 && page <= this.tableNews.last_page) {
        this.getNews(page);
      }
    }
  }
};
</script>

<style scoped>
.card {
  display: flex;
  flex-direction: column;
}

.card-body {
  flex: 1;
}

.card-img-top {
  max-height: 200px;
  object-fit: cover;
  width: 100%;
}
</style>
