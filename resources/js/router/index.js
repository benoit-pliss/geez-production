import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        redirect: { name: 'home' }
    },
    {
        path: '/sandbox',
        name: 'sandbox',
        component: () => import('../components/adminComponents/store-videos.vue'),
    },
    {
        path: '/home',
        name: 'home',
        component: () => import('../pages/home.vue'),
        data: { theme: 'dark' }
    },
    {
        path: '/photo',
        name: 'photo',
        component: () => import('../pages/photo.vue'),
        data: { theme: 'light' }
    },
    {
        path: '/video',
        name: 'video',
        component: () => import('../pages/video.vue'),
        data: { theme: 'light' }
    },
    {
        path: '/contact',
        name: 'contact',
        component: () => import('../pages/contact.vue'),
        data: { theme: 'light' }
    },
    {
        path: '/legal',
        name: 'legal',
        component: () => import('../pages/legal.vue'),
        data: { theme: 'dark' }
    },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: () => import('../pages/admin/dashboard.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/admin/login',
        name: 'login',
        component: () => import('../pages/admin/login.vue'),
        data: { theme: 'light' }
    },
    {
        path: '/admin/photos',
        name: 'admin-photos',
        component: () => import('../components/adminComponents/dashboard-photos.vue'),
        meta: { requiresAuth: true }
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
