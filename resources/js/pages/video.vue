<template>
    <div data-theme="light">
        <Navbar @replaceTag="replaceTag"></Navbar>
        <div :class="featuredVideo ? 'py-48 sm:py-64' : 'py-24 sm:py-32'" class="relative isolate overflow-hidden bg-gray-900 px-6 lg:px-8">
            <video v-if="featuredVideo"
                ref="videoRef"
                :src="featuredVideo.url"
                :poster="featuredVideo.poster_url"
                autoplay loop playsinline muted
                class="absolute inset-0 -z-10 h-full w-full object-cover"
            />
            <img v-else src="../../img/acceuil/static/video-1.jpeg" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gray-900 opacity-75 -z-10" />
            <template v-if="!featuredVideo">
                <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl" aria-hidden="true">
                    <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
                </div>
                <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu" aria-hidden="true">
                    <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
                </div>
            </template>
            <div class="mx-auto max-w-2xl text-center z-10">
                <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Galerie Vidéo</h2>
                <p class="mt-6 text-lg leading-8 text-gray-300">Découvrez ici nos différentes réalisations en matière d'audiovisuel. De la captation d'événements à la réalisation de vos clips vidéo nous sommes là pour vous accompagner.</p>
            </div>

            <!-- Boutons overlay vidéo vedette -->
            <div v-if="featuredVideo" class="absolute bottom-4 right-4 flex gap-2 z-10">
                <button @click="lightboxOpen = true" class="p-2 rounded-full bg-black/40 hover:bg-black/60 text-white backdrop-blur-sm transition">
                    <ArrowsPointingOutIcon class="h-5 w-5" />
                </button>
            </div>
        </div>

        <MediaLightbox v-if="featuredVideo" v-model="lightboxOpen" type="video" :src="featuredVideo.url" :poster="featuredVideo.poster_url" />

        <galerie :pageTag="pageTag"></galerie>
        <Footer></Footer>
    </div>
</template>

<script setup>

import Navbar from "@/components/NavbarVideo.vue";
import Footer from "@/components/FooterDark.vue";
import Galerie from "@/components/GalerieVideo.vue";
import MediaLightbox from '@/components/MediaLightbox.vue';
import { ArrowsPointingOutIcon } from '@heroicons/vue/24/solid';
import { onMounted, onUnmounted, ref, watch } from 'vue';
import { getSettings } from '../services/settingsService.js';

const pageTag = ref(null);
const featuredVideo = ref(null);
const videoRef = ref(null);
const lightboxOpen = ref(false);

let observer = null;

onMounted(async () => {
    try {
        const { data } = await getSettings();
        featuredVideo.value = data.featured_video ?? null;
    } catch { /* silencieux */ }
});

onUnmounted(() => {
    observer?.disconnect();
});

watch(videoRef, (el) => {
    if (!el) return;
    el.muted = true;
    el.play().catch(() => {
        const retry = () => el.play().catch(() => {});
        window.addEventListener('focus', retry, { once: true });
        document.addEventListener('click', retry, { once: true });
    });

    observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            el.play().catch(() => {});
        } else {
            el.pause();
        }
    }, { threshold: 0.1 });

    observer.observe(el);
});

const scrollDown = () => {
    document.getElementById('gallery').scrollIntoView({ behavior: 'smooth', block: 'start' });
};

const replaceTag = (tag) => {
    pageTag.value = tag;
    scrollDown();
};

</script>
