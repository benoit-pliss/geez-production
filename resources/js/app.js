import './bootstrap';

import { createApp } from 'vue';
import router from './router/index.js';

import App from "./components/app.vue";
import Home from "./pages/home.vue";
import Footer from "./components/footer-page.vue";
import Photography from "./pages/photography.vue";
import Audiovisual from "./pages/audiovisual.vue";


createApp({
    components: {
        App,
        Home,
        Footer,
        Photography,
        Audiovisual,
    }
}).use(router).mount('#app');



