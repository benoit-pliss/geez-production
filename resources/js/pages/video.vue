<template>
    <Navbar @replaceTag="replaceTag"></Navbar>
    <div class="relative isolate overflow-hidden bg-zinc-950 px-6 py-24 sm:py-32 lg:px-8">
        <img src="../../img/acceuil/static/video-1.jpeg" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover" />
        <div class="absolute inset-0 bg-zinc-950 opacity-75 -z-10" />
        <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl" aria-hidden="true">
            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
        </div>
        <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu" aria-hidden="true">
            <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
        </div>
        <div class="mx-auto max-w-2xl text-center z-10">
            <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Galerie Vidéo</h2>
            <p class="mt-6 text-lg leading-8 text-gray-300">Découvrez ici nos différentes réalisations en matière d'audiovisuel. De la captation d'événements à la réalisation de vos clips vidéo nous sommes là pour vous accompagner.</p>
        </div>
    </div>

    <galerie :pageTag="pageTag"></galerie>
    <Footer></Footer>
</template>

<script setup>

import Navbar from "@/components/NavbarVideo.vue";
import Footer from "@/components/FooterDark.vue";
import Galerie from "@/components/GalerieVideo.vue";
import { onMounted, ref } from 'vue';

const pageTag = ref(null);

const scrollDown = () => {
  document.getElementById('gallery').scrollIntoView({ behavior: 'smooth', block: 'start' });
};

const replaceTag = (tag) => {
  pageTag.value = tag;
    scrollDown();
};

</script>

