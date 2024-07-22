<template>
    <nav aria-label="Página de navegação">
      <ul class="pagination justify-content-center pt-4">
        <li
          class="page-item"
          :class="{ disabled: currentPage === 1 }"
          @click="changePage(currentPage - 1)"
        >
          <a class="page-link" href="#">Anterior</a>
        </li>
        <li
          class="page-item"
          :class="{ active: page === currentPage }"
          v-for="page in totalPages"
          :key="page"
          @click="changePage(page)"
        >
          <a class="page-link" href="#">{{ page }}</a>
        </li>
        <li
          class="page-item"
          :class="{ disabled: currentPage === totalPages }"
          @click="changePage(currentPage + 1)"
        >
          <a class="page-link" href="#">Próximo</a>
        </li>
      </ul>
    </nav>
</template>

<script>
  export default {
    name: 'Pagination',
    props: {
      currentPage: {
        type: Number,
        required: true
      },
      totalPages: {
        type: Number,
        required: true
      }
    },
    methods: {
      changePage(page) {
        if (page > 0 && page <= this.totalPages) {
          this.$emit('page-changed', page);
        }
      }
    }
  };
</script>
  
<style scoped>
.page-item.disabled .page-link {
    cursor: not-allowed;
    background-color: #c0c0c0;
    border-color: #c0c0c0;
}

.page-item.active .page-link {
    background-color: #004d00;
    border-color: #004d00;
}

.page-link {
    background-color: #34AB44;
    color: #ffffff;
    border: 1px solid #34AB44;
}

.page-link:hover {
    background-color: #006600;
    color: #ffffff;
}
</style>
  