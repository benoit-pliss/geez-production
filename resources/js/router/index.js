import { createRouter, createWebHistory } from 'vue-router';

import App from "../components/app.vue";
import Home from "../components/home.vue";
import Footer from "../components/footer.vue";
import Photography from "../components/photography.vue";
import Audiovisual from "../components/audiovisual.vue";

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
        component: Home
    },
    {
        path: '/photography',
        name: 'photography',
        component: Photography
    },
    {
        path: '/audiovisual',
        name: 'audiovisual',
        component: Audiovisual
    }

]


const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
