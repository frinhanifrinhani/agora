<template>
  <FlashMessage />

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Categorias / Nova Categoria</span>
      </li>
    </ol>
  </nav>

  <div class="content">
    <div class="top-content">
      <h2 class="mb-4">Cadastrar Categorias</h2>
    </div>

    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div class="form-area">
      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label for="name" class="form-label">Nome</label>
          <input
            type="text"
            id="name"
            v-model="formData.name"
            class="form-control"
            :class="{ 'is-invalid': useValidate.formData.name.$error }"
            @blur="useValidate.formData.name.$touch()"
            required
          />
          <!-- Mensagem de validação -->
          <div
            v-if="useValidate.formData.name.$invalid && useValidate.formData.name.$dirty"
            class="invalid-feedback"
          >
            <span v-if="useValidate.formData.name.required">O nome é obrigatório.</span>
            <br />
            <span v-if="useValidate.formData.name.minLength"
              >O nome deve ter pelo menos 2 caracteres.</span
            >
          </div>
        </div>

        <router-link to="/admin/categories" class="btn btn-danger"> Cancelar </router-link>
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
import CategoryAdminService from "@/service/admin/CategoryAdminService";
import { useFlashMessage } from "@/service/FlashMessageService";

export default {
  name: "CreateCategoryAdmin",
  data() {
    return {
      formData: {
        name: "",
      },
      isLoading: false,
    };
  },
  created() {
    this.CategoryAdminService = new CategoryAdminService();
  },
  validations() {
    return {
      formData: {
        name: { required, minLength: minLength(2) },
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

      if (!this.useValidate.$invalid) {
        this.createCategory(this.formData);
      }
    },

    async createCategory(data) {

        this.isLoading = true;
        const response = await this.CategoryAdminService.createCategory(data);

        if (response.success) {
          this.setFlashMessage(response.success.message, "success");
          this.$router.push("/admin/categories");
        }else{
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

label, input{
  color: rgba(0,0,0,.5) !important;
}

.btn {
  border-radius: 6px!important;
}

/* .alert-success {
  background-color: #d4edda;
  color: #155724;
} */
</style>
