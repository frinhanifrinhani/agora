<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Eventos</span>
      </li>
    </ol>
  </nav>
  <div class="event-list">
    <div class="top-list">
      <h2 class="mb-4">Eventos</h2>
      <a href="#" class="btn btn-primary">Cadastrar Evento</a>
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

            <th class="text-column-table-template">Data/Hora Inicio</th>
            <th class="text-column-table-template">Data/Hora Fim</th>
            <th class="text-column-table-template">Organizador</th>
            <th class="text-column-table-template">Local</th>

            <th class="text-column-table-template">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(event, index) in tableEvent.data" :key="index" class="align-middle">
            <td class="text-black-50">{{ event.id }}</td>
            <td class="text-black-50">{{ truncateText(event.title) }}</td>   

            <td class="text-black-50">{{ event.start_date }} {{event.start_time}}</td>   
            <td class="text-black-50">{{ event.end_date }} {{event.end_time}}</td>   
            <td class="text-black-50">{{ event.organizer }}</td>   
            <td class="text-black-50">{{ event.location }}</td>   
            
            <td>
              <button class="btn btn-primary btn-sm me-2" @click="viewEvent(event.id)">
                <i class="fa-regular fa-eye"></i>
              </button>
              <button class="btn btn-warning btn-sm me-2" @click="editEvent(event.id)">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
              <button class="btn btn-danger btn-sm" @click="deleteEvent(event.id)">
                <i class="fa-solid fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <Pagination
        :currentPage="tableEvent.current_page"
        :totalPages="tableEvent.last_page"
        @page-changed="changePage"
      />
    </div>
  </div>
</template>

<script>
import EventAdminService from "@/service/admin/EventAdminService";
import Pagination from "../../Pagination.vue";

export default {
  name: "EventAdmin",
  components: {
    Pagination,
  },
  data() {
    return {
      tableEvent: {
        data: [],
        current_page: 1,
        last_page: 1,
      },
      isLoading: false,
    };
  },
  created() {
    this.EventAdminService = new EventAdminService();
  },
  mounted() {
    this.getEvent();
  },
  methods: {
    truncateText(text) {
      if(text){
        const maxLength = 90;
        return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
      }
    },

    async getEvent(page = 1) {
      this.isLoading = true;
      const response = await this.EventAdminService.getIndexEvent(this.perPage, page);

      if (response) {
        this.tableEvent = {
          data: response.data.map((event) => ({
            ...event,
          })),
          current_page: response.current_page,
          last_page: response.last_page,
        };
      }

      this.isLoading = false;
    },
    changePage(page) {
      if (page > 0 && page <= this.tableEvent.last_page) {
        this.getEvent(page);
      }
    },
  },
};
</script>

<style scoped>
.event-list {
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
