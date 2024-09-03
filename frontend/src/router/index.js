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
import Login from '@/views/login/Login.vue'
import HomeDashboard from '@/views/dashboard/HomeDashboard.vue'

const routes = [
  { 
    path: '/',
    name: 'Home',
    component: import('@/views/Home.vue'),
    meta: { hideHeader: false, hideFooter: false },
  },
  { 
    path: '/noticias',
    name: 'News',
    component: import('@/views/news/News.vue'),
  },
  { 
    path: '/noticias/:id',
    name: 'NewsShow',
    component: import('@/views/news/NewsShow.vue'),
    props: true
  },
  {
    path: '/evento',
    name: 'Event',
    component: import('@/views/event/Event.vue'),
  },
  { 
    path: '/pagina-evento',
    name: 'EventPage',
    component: import('@/views/event/EventPage.vue'),
  },
  { 
    path: '/sobre',
    name: 'About',
    component: import('@/views/About.vue'),
  },
  { 
    path: '/agenda-2030', 
    name: 'Agenda2030', 
    component: import('@/views/Agenda2030.vue'),
  }, 
  { 
    path: '/evento/:id',
    name: 'EventShow',
    component: import('@/views/event/EventShow.vue'),
    props: true
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
    children: [
      {
        path: '',
        name: 'HomeDashboard',
        component: () => import('@/views/dashboard/HomeDashboard.vue'),
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
        component: () => import('@/views/user/User.vue'),
      },
    ],
    meta: { hideHeader: true, hideFooter: true },
  },
  { 
    path: '/login',
    name: 'Login',
    component: () => import('@/views/login/Login.vue'),
    meta: { hideHeader: true, hideFooter: true },
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;