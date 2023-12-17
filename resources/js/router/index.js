import { createRouter, createWebHistory } from 'vue-router';

import App from "../components/app.vue";
import Home from "../pages/home.vue";
import Footer from "../components/footer-page.vue";
import Photography from "../pages/photography.vue";
import Audiovisual from "../pages/audiovisual.vue";

const routes = [
    {
        path: '/',
        name: 'app',
        component : App,
    },
    {
        path: '/sandbox',
        name: 'sandbox',
        component: App,
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
        data: {
            theme: 'dark'
        }
    },
    {
        path: '/photography',
        name: 'photography',
        component: Photography,
        data: {
            theme: 'light'
        }
    },
    {
        path: '/audiovisual',
        name: 'audiovisual',
        component: Audiovisual,
        data: {
            theme: 'dark'
        }
    }

]


const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
