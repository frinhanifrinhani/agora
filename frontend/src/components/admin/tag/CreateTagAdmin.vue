
<template>
  <FlashMessage />

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span class="text-black-50">Home / Tags / Nova Tag</span>
      </li>
    </ol>
  </nav>

  <div class="list">
    <div class="top-list">
      <h2 class="mb-4">Tags</h2>
    </div>

    <div v-if="isLoading" class="d-flex justify-content-center align-items-center vh-100">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>

    <div class="form-area table table-hover">
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

        <button type="submit" class="btn btn-primary" :disabled="isLoading || useValidate.$invalid">Cadastrar</button>
      </form>
    </div>
  </div>
</template>

<script>
import { required, minLength } from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";
import TagAdminService from "@/service/admin/TagAdminService";
import { useFlashMessage } from "@/service/FlashMessageService";

export default {
  name: "CreateTagAdmin",
  data() {
    return {
      formData: {
        name: "",
      },
      isLoading: false,
    };
  },
  created() {
    this.TagAdminService = new TagAdminService();
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
        this.createTag(this.formData);
      }
      
    },
    async createTag(data) {
      try {
        this.isLoading = true;
        const response = await this.TagAdminService.createTag(data);

        if (response) {
          this.isLoading = false;
          this.setFlashMessage("Tag criada com sucesso!", "success");
          this.formData.name = "";
          this.$router.push("/admin/tags");
        }
      } catch (error) {
        this.setFlashMessage("Erro ao criar a tag. Tente novamente.", "error");
      } finally {
        this.isLoading = false;
      }
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

.list {
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

.form-area {
  padding: 25px 75px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}
</style>

