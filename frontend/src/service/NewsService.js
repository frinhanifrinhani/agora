import { getCurrentInstance } from 'vue';

export default class NewsService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexNews() {
        let req = null;

        try {
            req = await fetch(this.API_URL + 'news');

        } catch (error) {
            return false;
        }

        return await req.json();
    }
}