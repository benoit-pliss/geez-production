<script setup>
import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";

import { ref } from 'vue'
const hovered = ref('')

</script>

<template>
    <div data-theme="dark">
        <navbar></navbar>
        <!-- Create a height full screen with page divided in 2 of 50%, when hover on the one side the other side reduce this size to 30% and the hovered side increase to 70% -->
        <!-- Root Component Markup -->
        <div class="flex h-screen flex-col md:flex-row">
            <!-- Curtain 1 - Initially 50% and Increases to 70% on Hover -->
            <a class="relative w-full md:w-1/2 h-full hover:z-10 transition-all duration-500"
                @mouseover="hovered = 'left'" 
                @mouseleave="hovered = ''"
                :class="{ 'md:w-2/3 z-10': hovered === 'left', 'md:w-1/3 z-10': hovered === 'right'}"
                href="/photo">
                <img class="absolute inset-0 h-full w-full object-cover" src="/build/assets/static/home-1.jpeg" alt="Image">
                <div class="absolute inset-0 flex items-center justify-center flex-col bg-black bg-opacity-50">
                    <h1 class="text-4xl font-bold text-white">Photographie</h1>
                </div>
            </a>
            
            <!-- Curtain 2 - Initially 50% and Decreases to 30% on Hover of the other -->
            <a class="relative w-full md:w-1/2 h-full hover:z-10 transition-all duration-500"
                @mouseover="hovered = 'right'" 
                @mouseleave="hovered = ''"
                :class="{ 'md:w-1/3 z-10': hovered === 'left', ' md:w-2/3 z-10': hovered === 'right'}"
                href="/video">
                <video class="absolute inset-0 h-full w-full object-cover" autoplay loop muted>
                    <source src="/build/assets/static/home-2.mp4" type="video/mp4">
                </video>
                <div class="absolute inset-0 h-full flex items-center justify-center flex-col bg-black bg-opacity-50">
                    <h1 class="text-4xl font-bold text-white">Audiovisuel</h1>
                </div>
            </a>
        </div>
        <footer-page></footer-page>
    </div>
</template>

<script>
export default {
    data() {
        return {
            hovered: false
        };
    },
    onMounted() {
        console.log('mounted')
    }



};
</script>

<style scoped>.header-image {
    background-image: url('../../img/pexels-aleksandar-pasaric-1820770.jpg');
}</style>