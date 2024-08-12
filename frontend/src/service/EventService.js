import { getCurrentInstance } from 'vue';

export default class EventService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexEvent(limit = 10, page = 1) {
        try {
            const url = new URL(this.API_URL + 'events');
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
}