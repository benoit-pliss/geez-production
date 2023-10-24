import { createRouter, createWebHistory } from 'vue-router';

import Home from "../components/home.vue";

const routes = [
    {
        path: '/',
        name: 'home',
        component : Home,
    },
    {
        path: '/sandbox',
        name: 'sandbox',
        component: Home,
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
