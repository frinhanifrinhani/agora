<template>
    <div> 
        <div v-if="loading" class="d-flex justify-content-center align-items-center vh-100">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>
        
        <div v-if="news">
            <!--Seção breadcrumbs-->
            <div class="breadcrumbs-background">
                <div class="row justify-content-center m-2 p-2">
                    <section>
                        <h1>
                            {{ news.title }}
                        </h1>

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Ágora Fiocruz</a></li>
                                <li class="breadcrumb-item"><a href="#">2030 Agenda</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ news.title }}</li>
                            </ol>
                        </nav>
                    </section>
                </div>
            </div>
            
            <!--Seção notícia-->
            <div class="container justify-content-center">
                <div class="row no-gutters mt-5">
                    <div class="col-9">
                        <p class="card-text" v-html="news.body"></p>
                    </div>

                    <div class="col-3">
                        <nav class="navbar navbar-light bg-light">
                            <form class="form-search">
                                <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar">
                                <button class="btn btn-outline-success btn-sm custom-button-border" type="submit">BUSCAR</button>
                            </form>
                        </nav>

                        <div>
                            <h5 class="mt-5 color-green">POSTS RECENTES</h5>
                            <hr/>
                            <button type="button" class="custom-button-tags">
                                <small>Da ideia ao produto, Feira fomenta soluções em saúde digital</small>
                            </button>
                        </div>

                        <div>
                            <h5 class="mt-5 color-green">TAGS</h5>
                            <hr/>
                            <button type="button" class=" btn btn-outline-success custom-button-tags custom-button-border">
                                TAGS
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="container justify-content-center mb-5">
                <section class="col-md-10">
                    <div class="mb-3">
                        <i class="fa-solid fa-calendar-days color-green"></i>
                        <span class="ms-2 color-grey">
                            <FormattedDate :date="news.publication_date" />
                        </span>
                    </div>

                    <div>
                        <span class="color-grey">Compartilhar</span>
                        <i class="fa-brands fa-facebook icons-share color-green"></i>
                        <i class="fa-brands fa-instagram icons-share color-green"></i>
                        <i class="fa-solid fa-envelope icons-share color-green"></i>
                        <i class="fa-brands fa-linkedin icons-share color-green"></i>
                    </div>
                </section>
            </section>
        </div>        
    </div>
</template>

<script>
import NewsService from '../../service/NewsService';
import FormattedDate from '../FormattedDate.vue';

export default {
    name: "NewsShow",
    components: {
        FormattedDate,
    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
    return {
        news: null,
        loading: false
    };
  },
  created() {
    this.NewsService = new NewsService();
    this.fetchNewsDetails();
  },
  methods: {
    async fetchNewsDetails() {

        this.loading = true;
        try {
            const response = await this.NewsService.getShowNews(this.id);

            if (response && response.data) {
                this.news = response.data;
            } else {
                console.error('Notícia não encontrada.');
            }
            
        } catch (error) {
            console.error('Erro ao buscar a notícia:', error);
        } finally {
            this.loading = false;
        }

        this.loading = false;
    }
  }
};
</script>
