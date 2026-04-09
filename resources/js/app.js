import './bootstrap';

import { createApp } from 'vue';
import router from './router/index.js';
import App from "./components/app.vue";
import LazyLoad from "./directives/LazyLoad.js";

const app = createApp(App)
    .use(router)
    .directive('lazyload', LazyLoad);

router.isReady().then(() => {
    app.mount('#app');

    const loader = document.getElementById('initial-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.remove(), 400);
    }
});



