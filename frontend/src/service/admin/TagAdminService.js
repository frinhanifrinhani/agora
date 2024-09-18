import { getCurrentInstance } from 'vue';
import axios from 'axios';

export default class TagAdminService {
    API_URL = getCurrentInstance().appContext.config.globalProperties.$API_URL;

    async getIndexTag(limit = 10, page = 1) {
        try {
            const url = this.API_URL + 'admin/tags';
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

    async getTag(id){
        try {
            const url = this.API_URL + 'admin/tags/'+id;
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
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao buscar a tag!";
                
                return errorMessage
            }else{
                return error;
            }
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
            
            if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao criar a tag!";
                
                return errorMessage
            }else{
                return error;
            }
        }
    }

    async updateTag(data){
        
        const url = this.API_URL + 'admin/tags/'+data.id;
        const token = localStorage.getItem('authToken');
    
        try {
            const response = await axios.put(url, data, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            
            if(error.response){
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao atualizar a tag!";
                
                return errorMessage
            }else{
                return error;
            }
        }
    }

    async deleteTag(id){
        const url = this.API_URL + 'admin/tags/'+id;
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
                const errorMessage = error?.response?.data?.error?.message  || "Ocorreu um erro ao deletar a tag!";
                
                return errorMessage
            }else{
                return error;
            }
        }  
    }
}