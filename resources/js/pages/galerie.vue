<script setup>
import VueMasonry from 'vue-masonry-css'
import { ref, onMounted } from 'vue';
import axios from 'axios';

const images = ref([]);

async function fetchImages() {
    try {
        const response = await axios.get('/api/images');
        images.value = response.data.images;
    } catch (error) {
        console.log(error.response);
    }
}

onMounted(fetchImages); // Fetch images when the component is mounted
</script>

<template>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-xl text-center">
                <h2 class="text-lg font-semibold leading-8 tracking-tight text-indigo-600">Testimonials</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">We have worked with thousands of amazing people</p>
            </div>
            <div class="mx-auto mt-16 flow-root max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none">
                <div class="-mt-8 sm:-mx-4 sm:columns-2 sm:text-[0] lg:columns-3">
                    <div v-for="image in images" :key="image.name" class="pt-8 sm:inline-block sm:w-full sm:px-4">
                        <div class="overflow-hidden transition duration-300 transform rounded-lg hover:scale-105">
                            <img :src="image.url" class="object-cover w-full h-auto" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>






<style scoped>

</style>
