import { getCurrentInstance } from 'vue';
import axios from 'axios';

export default class TagAdminService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexTag(limit = 10, page = 1) {
        try {
            const url = new URL(this.API_URL + 'admin/tags');
            url.searchParams.append('limit', limit);
            url.searchParams.append('page', page);

            const token = localStorage.getItem('authToken');

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            return false;
        }
    }

    async createTag(data){
        const url = this.API_URL + 'admin/tags';
        const token = localStorage.getItem('authToken');
    
        try {
            const response = await axios.post(url, data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            throw new Error(`HTTP error! Status: ${error.response?.status || 'Http error'}`);
        }
    }

}