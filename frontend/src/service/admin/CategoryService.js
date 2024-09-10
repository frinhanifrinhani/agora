import { getCurrentInstance } from 'vue';

export default class CategoryService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexCategory(limit = 10, page = 1) {
        try {
            const url = new URL(this.API_URL + 'admin/categories');
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

    async unpublishCategory(id) {
        try {
            //const url = new URL(this.API_URL + 'admin/category');
        } catch (error) {
            return false;
        }
    }


}