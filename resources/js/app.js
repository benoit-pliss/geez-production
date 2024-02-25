import './bootstrap';

import { createApp } from 'vue';
import router from './router/index.js';

import App from "./components/app.vue";
import Home from "./pages/home.vue";
import Footer from "./components/footer-page.vue";
import Photo from "./pages/photo.vue";
import Video from "./pages/video.vue";


createApp({
    components: {
        App,
        Home,
        Footer,
        Photo,
        Video,
    }
}).use(router).mount('#app');



