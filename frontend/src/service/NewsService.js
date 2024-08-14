import { getCurrentInstance } from 'vue';

export default class NewsService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexNews(limit = 10, page = 1) {
        try {
            const url = new URL(this.API_URL + 'news');
            url.searchParams.append('limit', limit);
            url.searchParams.append('page', page);

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            return false;
        }
    }

    async getShowNews(id) {
        try {
            const url = new URL(this.API_URL + `news/${id}`);
            const response = await fetch(url);

            return await response.json();
        } catch (error) {
            console.error("Erro ao buscar os detalhes da notícia:", error);
            throw error;
        }
    }
}