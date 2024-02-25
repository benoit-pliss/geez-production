import { createRouter, createWebHistory } from 'vue-router';

import App from "../components/app.vue";
import Home from "../pages/home.vue";
import Photo from "../pages/photo.vue";
import Video from "../pages/video.vue";
import Contact from "../pages/contact.vue";

const routes = [
    {
        path: '/',
        redirect: { name: 'home' }

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
        path: '/photo',
        name: 'photo',
        component: Photo,
        data: {
            theme: 'light'
        }
    },
    {
        path: '/video',
        name: 'video',
        component: Video,
        data: {
            theme: 'light'
        }
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
        data: {
            theme: 'light'
        }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
