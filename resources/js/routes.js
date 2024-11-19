import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/login',
        name: 'login',
        component: () => import('./components/Login.vue'), // Componente de login
    },
    // outras rotas do Vue aqui
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;