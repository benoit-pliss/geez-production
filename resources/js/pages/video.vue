<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from "@headlessui/vue";


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

<template>
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
</template>

<style scoped>

</style>

