import { getCurrentInstance } from 'vue';
import axios from 'axios';

export default class EventAdminService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexEvent(limit = 10, page = 1) {
        try {
            const url = this.API_URL + 'admin/events';
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
}