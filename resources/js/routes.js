import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/home',
        name: 'home',
        component: () => import('./components/Home.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./components/Login.vue'), 
    },
    {
        path: '/',
        redirect: '/login', 
    },
    
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;