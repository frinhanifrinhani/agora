<template>
    <div>
      <div class="row justify-content-center">
        <div class="position-relative image-container">
          <div class="centered-title">
            <h1 style="color: #fff;
              border-color: #6dab3c;
              border-radius: 20px;
              line-height: 50px;
              font-weight: bolder;">
              SAÚDE & CTI PARA A AGENDA 2030
            </h1>
          </div>
          <div class="centered-button-emphasis">
            <a class="btn" style="color: #fff;
              border-color: #6dab3c;
              background-color: #6dab3c;
              border-radius: 20px;
              font-size: 14px;"
              href="#">
              <i class="fa-solid fa-calendar-days"></i>
              <span class="ms-2"> 06 a 08 de novembro de 2017</span>
            </a>
          </div>
          <div class="centered-button">              
            <a class="btn" style="background-color:#fff; color:#888888; border-radius: 20px; font-size: 14px;" href="/pagina-evento">
              <span class="me-2">Detalhes</span>
              <i class="fa-solid fa-angle-right"></i>
            </a>              
          </div>
          <img src="@/assets/images/banner-obj-des-sustentavel.jpg" class="img-fluid" alt="">
          <div class="col-md-11 d-flex centered-form justify-content-center bg-white text-dark p-5">
            <div class="col-3 py-2 ms-5 ps-5 d-flex align-items-center justify-content-end">
              <i class="fa-solid fa-magnifying-glass-plus"></i>
              <h5 class="ms-2">Pesquisar Evento:</h5>
            </div>
            <div class="col-3 p-2">
              <input type="text" class="form-control" placeholder="Palavras-chave">
            </div>
            <div class="col-3 p-2">
              <select class="form-select" aria-label="Default select example">
                <option selected>Categoria</option>
                <option value="2030-agenda">2030 Agenda</option>
                <option value="curso">Curso</option>
                <option value="encontro">Encontro</option>
                <option value="feira">Feira</option>
                <option value="oficina">Oficina</option>
                <option value="palestra">Palestra</option>
                <option value="reuniao">Reunião</option>
                <option value="seminario">Seminário</option>
                <option value="workshop">Workshop</option>
              </select>
            </div>
            <div class="col-2 p-2">
              <select class="form-select" aria-label="Default select example">
                <option selected>Status</option>
                <option value="upcoming">Próximos</option>
                <option value="incoming">Em andamento</option>
                <option value="expired">Expirado</option>
              </select>
            </div>              
            <div class="col-3 p-2">
              <button type="submit" class="btn btn-success">Pesquisar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center pb-4">
        <div class="col-md-8 align-items-center">
          <div class="p-4 text-center">
            <p class="h2">Últimas Atualizações <span style="color: #48773E;"><strong>Eventos</strong></span></p>
            <hr class="text-muted">
            <small>Filtre os eventos por Tipo</small>
          </div>
        </div>
      </div>
      <div class="text-center pb-4">
        <a class="btn" style="background-color: #fff; border-color: #48773E; border-radius: 20px; color: #48773E;" href="#">
            TODOS
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">2030 AGENDA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
          <span class="text-white">CURSO</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">ENCONTRO</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">FEIRA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">OFICINA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">PALESTRA</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">REUNIÃO</span>
        </a>
        <a class="btn m-2" style="border-radius: 20px; color: #48773E; background-color: #48773E;" href="#">
            <span class="text-white">MAIS</span>
        </a>
      </div>

      <div v-if="loading" class="d-flex justify-content-center align-items-center vh-100">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Carregando...</span>
        </div>
      </div>
  
      <div v-else>

        <div class="row justify-content-center">
          <div v-for="(event, index) in tableEvent.data" :key="index"
            class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center custom-card"
          >
            <div class="p-3 custom-card">
              <div class="card " :class="{ 'large-card': isLargeScreen, 'small-card': !isLargeScreen }">
                <ImageComponent 
                  v-if="event.files_events && event.files_events.length > 0" 
                  :imagePath="event.files_events[0].file.full_path" 
                />
                <div v-else class="no-image">
                  <p></p>
                </div>
                <div class="card-body">
                  <div class="pb-1">
                    <h5 class="card-title text-truncate" style="max-width: 100%;">
                      <router-link :to="{ name: 'EventShow', params: { id: event.id } }" rel="noopener noreferrer">
                        <strong>{{ event.title }}</strong>
                      </router-link>
                    </h5>
                  </div>
                  <div class="card-text-container mb-4" v-if="event.body.trim()" style="max-width: 100%;">
                    <p class="card-text" v-html="event.body"></p>
                  </div>
                  <div v-else>
                  </div>
                  <div class="card-info-area mb-0">
                    <div class="card-info">
                      <small>
                        <i class="fas fa-calendar-alt me-2"></i> 
                        <FormattedDate :date="event.publication_date" />
                      </small>
                    </div>
                    <router-link :to="{ name: 'EventShow', params: { id: event.id } }" class="btn btn-sm float-end">
                      <small class="text-white">MAIS</small>
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <Pagination
          :currentPage="tableEvent.current_page"
          :totalPages="tableEvent.last_page"
          @page-changed="changePage"
        />
      
    </div>
  </div>
</template>
  
<script>
import EventService from '../../service/EventService';
import FormattedDate from '../FormattedDate.vue';
import Pagination from '../Pagination.vue';
import ImageComponent from '../ImageComponent.vue';
import ResizeMixin from '../mixins/resize.js';

export default {
  name: "Event",
  components: {
    FormattedDate,
    Pagination,
    ImageComponent,
  },
  mixins: [ResizeMixin],
  data() {
    return {
      tableEvent: {
        data: [],
        current_page: 1,
        last_page: 1
      },
      loading: false
    };
  },
  created() {
    this.EventService = new EventService();
  },
  mounted() {
    this.getEvent();
  },
  methods: {
    async getEvent(page = 1) {
      this.loading = true;
      const response = await this.EventService.getIndexEvent(this.perPage, page);
      
      if (response) {
        this.tableEvent = {
          data: response.data.map(event => ({
            ...event,
            body: event.body
          })),
          current_page: response.current_page,
          last_page: response.last_page
        };
      }

      this.loading = false;
    },
    changePage(page) {
      if (page > 0 && page <= this.tableEvent.last_page) {
        this.getEvent(page);
      }
    }
  }
};
</script>

<style scoped>
.card {
  display: flex;
  flex-direction: column;
  height: auto !important;
}

.card-body {
  flex: 1;
}

.card-img-top {
  max-height: 20rem;
  object-fit: cover;
  width: 100%;
}

.large-card {
  width: 37em;
}

.small-card {
  width: 26rem;
}

@media (min-width: 1900px) {
  .custom-card {
    padding-left: 4rem;
    padding-right: 4rem;
  }
  .col-lg-5 {
    flex: 0 0 37%;
    max-width: 48%;
  }
}
</style>