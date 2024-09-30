<template>
  <FlashMessage />

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Notícias / Nova News</span>
      </li>
    </ol>
  </nav>

  <div class="content">
    <div class="top-content">
      <h2 class="mb-4">Cadastrar News</h2>
    </div>

    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div class="form-area">
      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label for="title" class="form-label">Nome</label>
          <input
            type="text"
            id="title"
            v-model="formData.title"
            class="form-control"
            :class="{ 'is-invalid': useValidate.formData.title.$error }"
            @blur="useValidate.formData.title.$touch()"
            required
          />
          <!-- Mensagem de validação -->
          <div
            v-if="
              useValidate.formData.title.$invalid && useValidate.formData.title.$dirty
            "
            class="invalid-feedback"
          >
            <span v-if="useValidate.formData.title.required"
              >O título é obrigatório.</span
            >
            <br />
            <span v-if="useValidate.formData.title.minLength"
              >O título deve ter pelo menos 2 caracteres.</span
            >
          </div>
        </div>
        <div class="mb-3">
          <label for="body" class="form-label">Notícia</label>
          <textarea
            id="body"
            v-model="formData.body"
            class="form-control"
            :class="{ 'is-invalid': useValidate.formData.body.$error }"
            @blur="useValidate.formData.body.$touch()"
            rows="10"
            required
          ></textarea>
          <!-- Mensagem de validação -->
          <div
            v-if="useValidate.formData.body.$invalid && useValidate.formData.body.$dirty"
            class="invalid-feedback"
          >
            <span v-if="useValidate.formData.body.required"
              >O notícia é obrigatória.</span
            >
            <br />
            <span v-if="useValidate.formData.body.minLength"
              >A notícia deve ter pelo menos 10 caracteres.</span
            >
          </div>
        </div>
        <div class="mb-3">
          <a href="#" class="btn btn-primary" @click="showCategories = true">
            Escolher Categorias
          </a>

          <Modal :isOpen="showCategories" @close="showCategories = false">
            <h2>Categorias</h2>
            <ul>
              <li v-for="category in categories" :key="category.id">
                <input
                  type="checkbox"
                  :value="category.id"
                  v-model="selectedCategories"
                />
                {{ category.name }}
              </li>
            </ul>
            <a href="#" class="btn btn-primary" @click="showCategories = false">
              Salvar Categorias
            </a>
          </Modal>

          <div>
            <h3>Categorias Escolhidas:</h3>
            <ul>
              <li v-for="category in selectedCategoriesDetails" :key="category.id">
                {{ category.name }}
              </li>
            </ul>
          </div>
        </div>
        <div class="mb-3">&nbsp;&nbsp;&nbsp;&nbsp;</div>
        <router-link to="/admin/news" class="btn btn-danger"> Cancelar </router-link>
        &nbsp;
        <button
          type="submit"
          class="btn btn-primary"
          :disabled="isLoading || useValidate.$invalid"
        >
          Cadastrar
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { required, minLength } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import NewsAdminService from "@/service/admin/NewsAdminService";
import { useFlashMessage } from "@/service/FlashMessageService";

import Modal from "../Modal.vue";

// const selectedCategoriesData = this.selectedCategoriesDetails.map((category) => ({
//   id: category.id
// }));

export default {
  name: "CreateNewsAdmin",

  data() {
    return {
      formData: {
        title: "",
        body: "",
        categories: [],
      },
      isLoading: false,
      showCategories: false,
      categories: [],
      selectedCategories: [],
    };
  },
  computed: {
    selectedCategoriesDetails() {
      return this.categories.filter((category) =>
        this.selectedCategories.includes(category.id)
      );
    },
  },
  components: {
    Modal,
  },
  mounted() {
    this.getCategories();
  },
  created() {
    this.NewsAdminService = new NewsAdminService();
  },
  validations() {
    return {
      formData: {
        title: { required, minLength: minLength(2) },
        body: { required, minLength: minLength(10) },
      },
    };
  },
  setup() {
    const useValidate = useVuelidate();
    const { setFlashMessage } = useFlashMessage();
    return { useValidate, setFlashMessage };
  },
  methods: {
    async submitForm() {
      this.useValidate.$touch();

      this.formData.categories = this.selectedCategoriesDetails.map(
        (category) => category.id
      );

      if (!this.useValidate.$invalid) {
        this.createNews(this.formData);
      }
    },

    async getCategories() {
      const response = await this.NewsAdminService.getCategories();
      this.categories = response.data; // Salva as categorias no estado
    },

    async createNews(data) {
      this.isLoading = true;
      const response = await this.NewsAdminService.createNews(data);

      if (response.success) {
        this.setFlashMessage(response.success.message, "success");
        this.$router.push("/admin/news");
      } else {
        this.setFlashMessage(response, "error");
      }

      this.isLoading = false;
    },
  },
};
</script>

<style scoped>
.is-invalid {
  border-color: #dc3545;
}
.invalid-feedback {
  color: #dc3545;
}

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

.form-area {
  padding: 25px 175px;
  border-collapse: separate;
  border-spacing: 0;
  width: 100%;
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label,
input {
  color: rgba(0, 0, 0, 0.5) !important;
}

.btn {
  border-radius: 6px !important;
}

/* .alert-success {
  background-color: #d4edda;
  color: #155724;
} */
.editor {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 6px;
}

.editor:focus {
  border-color: #aaa;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
