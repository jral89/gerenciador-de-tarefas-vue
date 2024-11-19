import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/home',
        name: 'home',
        component: () => import('./components/Home.vue'), // Componente de login
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./components/Login.vue'), // Componente de login
    },
    {
        path: '/',
        redirect: '/login', // Redireciona para login como rota padrão
    },
    // outras rotas do Vue aqui
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;