<template>
  <nav aria-label="Página de navegação">
    <ul class="pagination">
      <li class="page-item" :class="{ disabled: currentPage === 1 }">
        <a class="page-link" @click="changePage(currentPage - 1)" href="#">Anterior</a>
      </li>

      <li v-if="shouldShowFirstPage" class="page-item">
        <a class="page-link" @click="changePage(1)" href="#">1</a>
      </li>
      <li v-if="shouldShowFirstPage" class="page-item disabled">
        <span class="page-link">...</span>
      </li>

      <li v-for="page in pageNumbers" :key="page" class="page-item" :class="{ active: page === currentPage }">
        <a class="page-link" @click="changePage(page)" href="#">{{ page }}</a>
      </li>

      <li v-if="shouldShowLastPage" class="page-item disabled">
        <span class="page-link">...</span>
      </li>
      <li v-if="shouldShowLastPage" class="page-item">
        <a class="page-link" @click="changePage(totalPages)" href="#">{{ totalPages }}</a>
      </li>

      <li class="page-item" :class="{ disabled: currentPage === totalPages }">
        <a class="page-link" @click="changePage(currentPage + 1)" href="#">Próximo</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
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
  computed: {
    pageNumbers() {
      const pages = [];
      const start = Math.max(1, this.currentPage - 2);
      const end = Math.min(this.totalPages - 1, this.currentPage + 2);

      for (let page = start; page <= end; page++) {
        pages.push(page);
      }

      return pages;
    },
    shouldShowFirstPage() {
      return this.currentPage > 3;
    },
    shouldShowLastPage() {
      return this.currentPage < this.totalPages - 2;
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
.pagination {
  display: flex;
  justify-content: center;
}

.page-item {
  margin: 0 2px;
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

.page-item.disabled .page-link {
  pointer-events: none;
  border-color: #c0c0c0;
  background-color: #f8f9fa;
  color: #9ab19d;
}

.page-link:hover {
    background-color: #006600;
    color: #ffffff;
}
</style>
