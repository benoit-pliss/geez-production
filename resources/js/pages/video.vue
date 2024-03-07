<template>
    <div data-theme="light">
        <navbar></navbar>

        <div class="relative isolate overflow-hidden bg-gray-900 px-6 py-24 sm:py-32 lg:px-8">
            <img src="../../img/acceuil/static/video-1.jpeg" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gray-900 opacity-75 -z-10" />
            <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl" aria-hidden="true">
                <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
            </div>
            <div class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu" aria-hidden="true">
                <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" />
            </div>
            <div class="mx-auto max-w-2xl text-center z-10">
                <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Patience</h2>
                <p class="mt-6 text-lg leading-8 text-gray-300">Nos développeurs travaillent d'arrache-pied pour vous offrir une expérience unique. Revenez bientôt pour découvrir notre contenu.</p>
            </div>
        </div>

        <footer-page></footer-page>
    </div>
</template>
        <!--
        <div class="bg-white">
            <section aria-labelledby="features-heading" class="mx-auto max-w-7xl py-32 sm:px-2 lg:px-8">
                <div class="mx-auto max-w-2xl px-4 lg:max-w-none lg:px-0">
                    <div class="max-w-3xl">
                        <h2 id="features-heading" class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            Audiovisuel</h2>
                        <p class="mt-4 text-gray-500">The Organize modular system offers endless options for arranging your
                            favorite and most used items. Keep everything at reach and in its place, while dressing up your
                            workspace.</p>
                    </div>

                    <TabGroup as="div" class="mt-4">
                        <div class="-mx-4 flex overflow-x-auto sm:mx-0">
                            <div class="flex-auto border-b border-gray-200 px-4 sm:px-0">
                                <TabList class="-mb-px flex space-x-10">
                                    <Tab as="template" v-for="tab in tabs" :key="tab.name" v-slot="{ selected }">
                                        <button
                                            :class="[selected ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 py-6 text-sm font-medium']">{{
                                                tab.name }}</button>
                                    </Tab>
                                </TabList>
                            </div>
                        </div>

                        <TabPanels as="template">
                            <TabPanel v-for="tab in tabs" :key="tab.name" class="space-y-16 pt-10 lg:pt-16">
                                <div v-for="feature in tab.features" :key="feature.name"
                                    class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:gap-x-8">
                                    <div class="mt-6 lg:col-span-5 lg:mt-0">
                                        <h3 class="text-lg font-medium text-gray-900">{{ feature.name }}</h3>
                                        <p class="mt-2 text-sm text-gray-500">{{ feature.description }}</p>
                                    </div>
                                    <div class="lg:col-span-7">
                                        <div
                                            class="overflow-hidden rounded-lg bg-gray-100 aspect-w-16 aspect-h-9 lg:aspect-none">
                                            <img :src="feature.mainVideoSrc" :alt="feature.name"
                                                class="object-cover object-center" />
                                        </div>
                                    </div>
                                </div>
                            </TabPanel>
                        </TabPanels>
                    </TabGroup>
                </div>
            </section>
        </div>
        -->

<script setup>

import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";
const tabs = [
  {
    name: 'ALCHEMIA LOUNGE CUISINE',
    features: [
      {
        name: 'Adaptive and modular',
        description:
          'The Organize base set allows you to configure and evolve your setup as your items and habits change. The included trays and optional add-ons are easily rearranged to achieve that perfect setup.',
        mainVideoSrc: 'http://localhost:8000/storage/videos/ALCHEMIA%20LOUNGE%20CUISINE/BCDD794F-665D-4FBD-B58D-C457D492280C.MOV',
      },
    ],
  },
]

import { ref, onMounted } from 'vue';
import axios from 'axios';

const videos = ref([]);

async function fetchVideos() {
    try {
        const response = await axios.get('/api/videos/ALCHEMIA LOUNGE CUISINE');
        videos.value = response.data.videos;
    } catch (error) {
        console.log(error.response);
    }
}

onMounted(fetchVideos); // Fetch images when the component is mounted
</script>

