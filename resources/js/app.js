import './bootstrap';

import { createApp } from 'vue';
import router from './router/index.js';

import App from "./components/app.vue";
import Home from "./components/home.vue";
import Footer from "./components/footer.vue";
import Photography from "./components/photography.vue";
import Audiovisual from "./components/audiovisual.vue";


createApp({
    components: {
        App,
        Home,
        Footer,
        Photography,
        Audiovisual,
    }
}).use(router).mount('#app');



