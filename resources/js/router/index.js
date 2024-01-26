import { createRouter, createWebHistory } from 'vue-router';

import App from "../components/app.vue";
import Home from "../pages/home.vue";
import Footer from "../components/footer-page.vue";
import Photography from "../pages/photography.vue";
import Audiovisual from "../pages/audiovisual.vue";

// partie sandbox
import Login from "../pages/admin/login.vue";
import Galerie from "../pages/galerie.vue";
import Dashboard from "../pages/admin/dashboard.vue";
import StoreImage from "../components/adminComponents/store-image.vue";
import Notifications from "../components/adminComponents/notifications.vue";

const routes = [
    {
        path: '/',
        name: 'app',
        component : App,
    },
    {
        path: '/sandbox',
        name: 'sandbox',
        component: Notifications,
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
        component: Galerie,
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
    },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: Dashboard,
        data: {
            theme: 'light'
        },
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
