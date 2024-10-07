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

    async getNews(id){
        try {
            const url = this.API_URL + 'admin/news/'+id;
            const token = localStorage.getItem('authToken');
    
            const response = await axios.get(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                
            });
    
            return response.data;
        } catch (error) {
             if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao buscar a notícia!";
                
                return errorMessage
            }else{
                return error;
            }
        }
    }

    async getCategories(){
        try {
            const url = this.API_URL + 'admin/categories/choice/all';
            const token = localStorage.getItem('authToken');
    
            const response = await axios.get(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
    
            return response.data;
        } catch (error) {
            return false;
        }
    }

    async getTags(){
        try {
            const url = this.API_URL + 'admin/tags/choice/all';
            const token = localStorage.getItem('authToken');
    
            const response = await axios.get(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
    
            return response.data;
        } catch (error) {
            return false;
        }
    }

    async createNews(data){
        const url = this.API_URL + 'admin/news';
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
            
            if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao criar a notícia!";
                
                return errorMessage
            }else{
                return error;
            }
        }
    }

    async deleteNews(id){
        const url = this.API_URL + 'admin/news/'+id;
        const token = localStorage.getItem('authToken');
    
        try {
            const response = await axios.delete(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                data: {
                    id: id 
                }
            });
            return response.data;
        } catch (error) {
            
            if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao deletar a notícia!";
                
                return errorMessage
            }else{
                return error;
            }
        }  
    }

    async publishNews(id){
        
        const url = this.API_URL + 'admin/news/publish/'+id;
        const token = localStorage.getItem('authToken');
        
        try {
            const response = await axios.put(url, {}, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            
            return response.data;
        } catch (error) {
            
            if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao publicar a notícia!";
                
                return errorMessage
            }else{
                return error;
            }
        }  
    }

    async unpublishNews(id){
        
        const url = this.API_URL + 'admin/news/unpublish/'+id;
        const token = localStorage.getItem('authToken');
        
        try {
            const response = await axios.put(url, {}, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            
            return response.data;
        } catch (error) {
            
            if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao despublicar a notícia!";
                
                return errorMessage
            }else{
                return error;
            }
        }  
    }

}