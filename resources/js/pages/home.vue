<template>
    <div data-theme="dark">
        <Navbar></Navbar>
        <!-- Create a height full screen with page divided in 2 of 50%, when hover on the one side the other side reduce this size to 30% and the hovered side increase to 70% -->
        <!-- Root Component Markup -->
        <div class="flex h-screen flex-col md:flex-row">
            <!-- Curtain 1 - Initially 50% and Increases to 70% on Hover -->
            <a class="relative w-full md:w-1/2 h-full hover:z-10 transition-all duration-500"
                @mouseover="hovered = 'left'"
                @mouseleave="hovered = ''"
                :class="{ 'md:w-2/3 z-10': hovered === 'left', 'md:w-1/3 z-10': hovered === 'right'}"
                href="/photo">
                <img class="absolute inset-0 h-full w-full object-cover" src="../../img/acceuil/static/home-1.jpeg" alt="Image">
                <div class="absolute inset-0 flex items-start justify-end flex-col pb-20"> <!-- bg-black bg-opacity-50 -->
                    <h1 class="text-4xl font-bold text-white backdrop-blur-md px-10 py-3 bg-gray-100/10 rounded-r-xl">Photographie</h1>
                </div>
            </a>

            <!-- Curtain 2 - Initially 50% and Decreases to 30% on Hover of the other -->
            <a class="relative w-full md:w-1/2 h-full hover:z-10 transition-all duration-500"
                @mouseover="hovered = 'right'"
                @mouseleave="hovered = ''"
                :class="{ 'md:w-1/3 z-10': hovered === 'left', ' md:w-2/3 z-10': hovered === 'right'}"
                href="/video">
                <video class="absolute inset-0 h-full w-full object-cover" autoplay loop muted>
                    <source src="../../img/acceuil/static/home-2.mp4" type="video/mp4">
                </video>
                <div class="absolute inset-0 flex items-end justify-end flex-col pb-20">
                    <h1 class="text-4xl font-bold text-white backdrop-blur-md px-10 py-3 bg-gray-100/25 rounded-l-xl">Audiovisuel</h1>
                </div>
            </a>
        </div>
        <div class="bg-gray-600 py-24 sm:py-32">
            <div class="relative isolate">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="mx-auto flex max-w-2xl flex-col gap-16 bg-white/5 px-6 py-16 ring-1 ring-white/10 sm:rounded-3xl sm:p-8 lg:mx-0 lg:max-w-none lg:flex-row lg:items-center lg:py-20 xl:gap-x-20 xl:px-20">
                    <!--<img class="h-96 w-48 flex-none rounded-2xl object-cover shadow-xl lg:aspect-square lg:h-auto lg:max-w-sm" src="https://images.unsplash.com/photo-1519338381761-c7523edc1f46?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80" alt="" />-->
                    <nav class="w-full flex-auto">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Une question ? Une réponse !</h2>
                        <p class="mt-6 text-lg leading-8 text-gray-300">Vous avez une demande particulière ? Vous souhaitez en savoir plus sur nos services ? N'hésitez pas à nous contacter, nous serons ravis de vous répondre.</p>
                        <ul role="list" class="mt-10 grid grid-cols-1 gap-x-8 gap-y-3 text-base leading-7 text-white sm:grid-cols-2">
                            <li v-for="benefit in benefits" :key="benefit" class="flex gap-x-3">
                                <CheckCircleIcon class="h-7 w-5 flex-none" aria-hidden="true" />
                                {{ benefit }}
                            </li>
                        </ul>
                        <div class="mt-10 flex">
                        <a href="/contact" class="text-sm font-semibold leading-6 text-white bg-white/10 px-3 py-2 rounded-md hover:bg-white/20 transition-all duration-200">Contactez-nous <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </nav>
                    </div>
                </div>
                <div class="absolute inset-x-0 -top-16 -z-10 flex transform-gpu justify-center overflow-hidden blur-3xl" aria-hidden="true">
                    <div class="aspect-[1318/752] w-[82.375rem] flex-none bg-gradient-to-r from-[#80caff] to-[#4f46e5] opacity-25" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)" />
                </div>
            </div>
        </div>
        <Footer></Footer>
    </div>
    
</template>

<script setup>
import { CheckCircleIcon } from '@heroicons/vue/20/solid'
import Navbar from "@/components/NavbarHome.vue";
import Footer from "@/components/FooterLight.vue";

import { ref } from 'vue'
const hovered = ref('')

const benefits = [
    'Evénements privés et professionnels',
    'Séances photos en studio ou en extérieur',
    'Portraits individuels et de groupe',
    'Photographie d’entreprise et de produits',
    'Retouches et montages photos',
    'Clip vidéo et montage',
    'Reportages et interviews',
    'Captation et montage de conférences',
    'Création de contenu audiovisuel',
]

</script>

<style scoped>
</style>
