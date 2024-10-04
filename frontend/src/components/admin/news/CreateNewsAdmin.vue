<template>
  <FlashMessage />

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Notícias / Nova Notícia</span>
      </li>
    </ol>
  </nav>

  <div class="content">
    <div class="top-content">
      <h2 class="mb-4">Cadastrar Notícia</h2>
    </div>

    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div class="form-area">
      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label for="title" class="form-label">Título</label>
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
          <!-- <textarea
            id="body"
            v-model="formData.body"
            class="form-control"
            :class="{ 'is-invalid': useValidate.formData.body.$error }"
            @blur="useValidate.formData.body.$touch()"
            rows="10"
            required
          ></textarea> -->
          <div>
            <quill-editor
              v-model="formData.body"
              class="form-control"
              :options="editorOptions"
              @blur="onEditorBlur"
              @input="onEditorInput"
              style="height: 400px"
            />
          </div>
          <!-- Mensagem de validação -->

          <br />
        </div>

        <!-- categorias -->
        <div class="mb-3">
          <multiselect
            v-model="selectedCategories"
            :options="categories"
            :multiple="true"
            :searchable="true"
            placeholder="Selecione a(s) categoria(s)"
            label="name"
            track-by="id"
          >
          </multiselect>
        </div>

        <!-- Tags -->
        <div class="mb-3">
          <multiselect
            v-model="selectedTags"
            :options="tags"
            :multiple="true"
            :searchable="true"
            placeholder="Selecione a(s) tag(s)"
            label="name"
            track-by="id"
          >
          </multiselect>
        </div>

        <div class="mb-3 radio-buttons">
          <label
            class="btn btn-outline-primary"
            :class="{ active: formData.publicated === '1' }"
          >
            <input
              type="radio"
              name="publicated"
              id="true"
              value="1"
              v-model="formData.publicated"
              autocomplete="off"
              class="d-none"
            />
            Publicado
          </label>

          <label
            class="btn btn-outline-danger"
            :class="{ active: formData.publicated === '0' }"
          >
            <input
              type="radio"
              name="publicated"
              id="false"
              value="0"
              v-model="formData.publicated"
              autocomplete="off"
              class="d-none"
            />
            Despublicado
          </label>
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
import { reactive } from "vue";
import { required, minLength } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import NewsAdminService from "@/service/admin/NewsAdminService";
import { useFlashMessage } from "@/service/FlashMessageService";

import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";

import { QuillEditor } from "@vueup/vue-quill"; // Update import
import "@vueup/vue-quill/dist/vue-quill.snow.css"; // or 'vue-quill.bubble.css'

export default {
  name: "CreateNewsAdmin",

  setup() {
    const useValidate = useVuelidate();
    const { setFlashMessage } = useFlashMessage();

    const formData = reactive({
      title: "",
      body: "",
      publicated: "1",
      isChecked: true,
      tags: [],
    });

    return { useValidate, setFlashMessage, formData };
  },

  data() {
    return {
      isLoading: false,
      editorOptions: {
        modules: {
          toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ indent: "-1" }, { indent: "+1" }],
            [{ size: ["small", false, "large", "huge"] }],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ color: [] }, { background: [] }],
            [{ font: [] }],
            [{ align: [] }],
            ["clean"],
          ],
        },
      },
      showCategories: false,
      showTags: false,
      categories: [],
      tags: [],
      selectedCategories: [],
      selectedTags: [],
    };
  },
  components: {
    Multiselect,
    QuillEditor,
  },
  mounted() {
    this.getCategories();
    this.getTags();
  },
  created() {
    this.NewsAdminService = new NewsAdminService();
  },
  validations() {
    return {
      formData: {
        title: { required, minLength: minLength(2) },
        body: {},
      },
    };
  },
  methods: {
    async submitForm() {
      this.useValidate.$touch();

      var editorElement = document.querySelector(".ql-editor");
      var innerHTMLValue = editorElement.innerHTML;
      this.formData.body = innerHTMLValue;
      this.formData.categories = this.selectedCategories.map((category) => category.id);
      this.formData.tags = this.selectedTags.map((tag) => tag.id);

      console.log(this.formData);
      if (!this.useValidate.$invalid) {
        this.createNews(this.formData);
      }
    },

    async getCategories() {
      const response = await this.NewsAdminService.getCategories();
      this.categories = response.data;
    },

    async getTags() {
      const response = await this.NewsAdminService.getTags();
      this.tags = response.data;
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

/* .custom-quill-editor .ql-container {
  height: 300px!important; 
} */

.btn {
  border-radius: 6px !important;
}

.editor {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 6px;
}

.editor:focus {
  border-color: #aaa;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.modal-content ul {
  display: flex !important;
  flex-wrap: wrap !important;
  list-style-type: none !important;
  padding: 0 !important;
  margin: 0 !important;
  width: 100%;
  overflow-y: scroll;
}

.modal-content .btn-primary {
  margin: 0 auto;
  width: 250px;
}
.modal-content li {
  flex: 1 1 200px;
  margin: 10px;
}

.card {
  width: 100%;
  padding: 10px;
}

.card .btn {
  width: 250px;
  margin: 0 auto;
}

.card {
  min-height: 100px !important;
  height: auto !important;
  background: #fafafa;
}
.card-body ul {
  display: flex !important;
  flex-wrap: wrap !important;
  list-style-type: none !important;
  padding: 0 !important;
  margin: 0 !important;
  width: 100%;
}

.card-body li {
  flex: 1 1 200px;
  margin: 1px;
}

.radio-buttons .active{
  color: #FFF !important;
}

.radio-buttons .btn:hover{
  color: #FFF !important;
}

.radio-buttons .btn-outline-primary{
  border-radius: 6px 0 0 6px !important;
  border-right: 0px !important;
}

.radio-buttons .btn-outline-danger{
  border-radius:  0 6px 6px 0 !important;
  border-left: 0px !important;
}
</style>
