import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import News from '../views/news/News.vue'
import Event from '../views/event/Event.vue'
import EventPage from '../views/event/EventPage.vue'
import EventOverview from '../views/event/EventOverview.vue'
import About from '../views/About.vue'
import Agenda2030 from '../views/Agenda2030.vue'

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/noticias', name: 'News', component: News },
  { path: '/evento', name: 'Event', component: Event },
  { path: '/pagina-evento', name: 'EventPage', component: EventPage },
  { path: '/sobre', name: 'About', component: About },
  { path: '/agenda-2030', name: 'Agenda2030', component: Agenda2030}, 
  { path: '/evento-resumo', name: 'EventOverview', component: EventOverview},

];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;