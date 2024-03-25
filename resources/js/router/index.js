import { createRouter, createWebHistory } from 'vue-router';

import Home from "../pages/home.vue";

import Login from "../pages/admin/login.vue";
import Dashboard from "../pages/admin/dashboard.vue";
import Photo from "../pages/photo.vue";
import Video from "../pages/video.vue";
import Contact from "../pages/contact.vue";
import Legal from "../pages/legal.vue";
import DashboardPhotos from "../components/adminComponents/dashboard-photos.vue";
import CarouselVideos from "../components/videos/carousel-videos.vue";

const routes = [
    {
        path: '/',
        redirect: { name: 'home' }

    },
    {
        path: '/sandbox',
        name: 'sandbox',
        component: CarouselVideos,
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
    },
    {
        path: '/legal',
        name: 'legal',
        component: Legal,
        data: {
            theme: 'dark'
        }
    },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/admin/login',
        name: 'login',
        component: Login,
        data: {
            theme: 'light'
        }
    },
    {
        path: '/admin/photos',
        name: 'admin-photos',
        component: DashboardPhotos,
        meta: {
            requiresAuth: true
        }
    }

]


const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        next({ name: 'login' });
    } else if (to.name === 'login' && localStorage.getItem('token')) {
        next({ name: 'dashboard' });
    } else if (to.name === 'register' && localStorage.getItem('token')) {
        next({ name: 'dashboard' });
    }
    else {
        next();
    }
});

export default router;
