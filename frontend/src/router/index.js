import { createRouter, createWebHistory } from 'vue-router'

import Home from '@/views/Home.vue'
import News from '@/views/news/News.vue'
import Event from '@/views/event/Event.vue'
import EventPage from '@/views/event/EventPage.vue'
import EventShow from '@/views/event/EventShow.vue'
import NewsShow from '@/views/news/NewsShow.vue'
import About from '@/views/About.vue'
import Agenda2030 from '@/views/Agenda2030.vue'
import Dashboard from '@/views/dashboard/Dashboard.vue'
// import Login from '@/views/login/Login.vue'
import Login from '@/components/login/Login.vue'
import HomeDashboard from '@/views/dashboard/HomeDashboard.vue'
import User from '@/views/user/User.vue';

const routes = [
  { path: '/',
    name: 'Home',
    component: Home,
    meta: { hideHeader: false, hideFooter: false },
  },
  { path: '/noticias', name: 'News', component: News },
  { path: '/noticias/:id', name: 'NewsShow', component: NewsShow, props: true },
  { path: '/evento', name: 'Event', component: Event },
  { path: '/pagina-evento', name: 'EventPage', component: EventPage },
  { path: '/sobre', name: 'About', component: About },
  { path: '/agenda-2030', name: 'Agenda2030', component: Agenda2030}, 
  { path: '/evento/:id', name: 'EventShow', component: EventShow, props: true},
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    children: [
      {
        path: '',
        name: 'HomeDashboard',
        component: HomeDashboard,
      },
      /* { 
        path: 'news',
        name: 'News',
        component: NewsDashboard,
      },
      { 
        path: 'event',
        name: 'Event',
        component: EventDashboard,
      }, */
      { 
        path: 'user',
        name: 'User',
        component: User,
      },
    ],
    meta: { hideHeader: true, hideFooter: true },
  },
  { 
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { hideHeader: true, hideFooter: true },
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;