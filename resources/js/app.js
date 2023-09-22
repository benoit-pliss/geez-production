import './bootstrap';

import { createApp } from 'vue';
import router from './router/index.js';

import Home from "./components/home.vue";


createApp({
    components: {
        Home,
    }
}).use(router).mount('#app');
