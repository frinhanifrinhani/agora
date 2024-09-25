<template>
  <FlashMessage />

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Categorys / {{ category.name }}</span>
      </li>
    </ol>
  </nav>

  <div class="content">
    <div class="top-content">
      <h2 class="mb-4">Category</h2>
    </div>

    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div class="view-area">
      <div class="content-view-area">
        <div class="content-view-line">
          <div class="label">ID:</div>
          <div>{{ category.id }}</div>
        </div>
        <div class="content-view-line">
          <div class="label">Nome:</div>
          <div>{{ category.name }}</div>
        </div>
        <div class="content-view-line">
          <div class="label">Alias:</div>
          <div>{{ category.alias }}</div>
        </div>
      </div>

      <router-link to="/admin/categories" class="btn btn-danger"> Cancelar </router-link>
      &nbsp;
      <router-link :to="{ name: 'EditCategoryAdmin', params: { id: category.id } }" class="btn btn-primary"> Editar </router-link>

    </div>
  </div>
</template>

<script>
import CategoryAdminService from "@/service/admin/CategoryAdminService";
import { useFlashMessage } from "@/service/FlashMessageService";

export default {
  name: "ViewCategoryAdmin",
  data() {
    return {
      category: {
        id: null,
        name: "",
        alias: "",
      },
      isLoading: false,
    };
  },
  created() {
    this.CategoryAdminService = new CategoryAdminService();
    this.getCategory();
  },
  setup() {
    const { setFlashMessage } = useFlashMessage();
    return { setFlashMessage };
  },
  methods: {
    async getCategory() {
      const id = this.$route.params.id;

      this.loading = true;

      try {
        const response = await this.CategoryAdminService.getCategory(id);

        if (response && response.data) {
          this.category = response.data;
        } else {
          this.setFlashMessage(response, "error");
          this.$router.push("/admin/categories");
        }
      } catch (error) {
        this.setFlashMessage(error.message, "error");
        this.$router.push("/admin/categories");
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

/* .alert-success {
  background-color: #d4edda;
  color: #155724;
} */
</style>
