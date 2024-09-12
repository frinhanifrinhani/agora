import { getCurrentInstance } from 'vue';
import axios from 'axios';

export default class NewsAdminService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexNews(limit = 10, page = 1) {
        try {
            const url = this.API_URL + 'admin/news';
            const token = localStorage.getItem('authToken');
    
            const response = await axios.get(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                params: {
                    limit: limit,
                    page: page
                }
            });
    
            return response.data;
        } catch (error) {
            return false;
        }
    }

    async unpublishNews(id) {
        try {
            //const url = new URL(this.API_URL + 'admin/news');
        } catch (error) {
            return false;
        }
    }

}