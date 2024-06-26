import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import News from '../views/news/News.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/noticias', name: 'News', component: News },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;