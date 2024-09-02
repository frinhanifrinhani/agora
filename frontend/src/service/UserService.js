import { getCurrentInstance } from 'vue';

export default class AuthService {
  API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

  async fetchUsers() {
    try {
      const token = localStorage.getItem('authToken');
      const response = await fetch(`${this.API_URL}users`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`,
        },
      });

      if (!response.ok) {
        throw new Error('Erro ao buscar usuários');
      }

      return await response.json();
    } catch (error) {
      throw new Error('Erro ao buscar usuários: ' + error.message);
    }
  }
}
