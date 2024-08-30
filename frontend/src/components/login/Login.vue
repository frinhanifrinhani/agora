<template>
  <div class="login-container">
    <div class="card login-card">
      <div class="card-body">
        <h4 class="card-title text-center mb-0">Login</h4>
        <form @submit.prevent="login">
          <div class="mb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" v-model="email" class="form-control" id="email" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" v-model="password" class="form-control" id="password" required />
          </div>
          <button type="submit" class="btn btn-success w-100" :disabled="isLoading">
            <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span v-if="isLoading">Entrando...</span>
            <span v-else>Entrar</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import AuthService from '@/service/AuthService';

export default {
  data() {
    return {
      email: '',
      password: '',
      isLoading: false
    };
  },
  created() {
    this.AuthService = new AuthService();
  },
  methods: {
    async login() {
      try {
        this.isLoading = true;
        const response = await this.AuthService.login(this.email, this.password);
        console.log('Login bem-sucedido:', response);

        this.$router.push({ name: 'Dashboard' });
      } catch (error) {
        console.error('Erro ao fazer login:', error);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f8f9fa;
}

.login-card {
  width: 100%;
  max-width: 400px;
  border-radius: 10px;
  border: 1px solid #5ab25e;
}

.btn-primary {
  background-color: #5ab25e;
  border-color: #5ab25e;
  border-radius: 5px;
}

.btn-primary:hover {
  background-color: #4a914d;
  border-color: #4a914d;
}

.card-title {
  color: #5ab25e;
}
</style>
