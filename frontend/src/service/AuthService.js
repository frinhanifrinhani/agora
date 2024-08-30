import { getCurrentInstance } from 'vue';

export default class AuthService {
  API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

  async login(email, password) {
    try {
      const url = this.API_URL + 'login'
      
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: email,
          password: password,
        }),
      });

      const data = await response.json();
      localStorage.setItem('authToken', data.token);
      return data;
    } catch (error) {
        throw new Error('Erro ao fazer login: '+ error);
    }
  }

  async logout() {
    try {
      const url = this.API_URL + 'logout'
      
      const token = localStorage.getItem('authToken');

      if (token) {
        await fetch(url, {
          method: 'POST',
          headers: {
            'Auth-Type': `Bearer ${token}`,
          },
        });

        localStorage.removeItem('authToken');
        this.$router.push({ name: 'Login' });
      }

    } catch (error) {
        throw new Error('Erro ao fazer logout: '+ error);
    }
    
  }
}