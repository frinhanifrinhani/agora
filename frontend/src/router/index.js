import { createRouter, createWebHistory } from 'vue-router'

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
    path: '/noticias/:id',//alias
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
  // ROTAS ADMIN
  {
    path: '/admin',
    name: 'Dashboard',
    component: () => import('@/views/admin/Dashboard.vue'),
    children: [
      {
        path: '',
        name: 'HomeDashboard',
        component: () => import('@/views/admin/HomeDashboard.vue'),
      },
      // categories
      {
        path: 'categories',
        name: 'CategoryAdmin',
        component: () => import('@/views/admin/category/CategoryAdmin.vue'),
      },
      // tag
      {
        path: 'tags',
        name: 'TagAdmin',
        component: () => import('@/views/admin/tag/Tag.vue'),
      },
      // news
      {
        path: 'news',
        name: 'NewsAdmin',
        component: () => import('@/views/admin/news/News.vue'),
      },
      //event
      {
        path: 'events',
        name: 'EventAdmin',
        component: () => import('@/views/admin/event/Event.vue'),
      },
      {
        path: 'news/create',
        name: 'CreateNews',
        component: () => import('@/views/admin/news/CreateNews.vue'),
      },
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