<script setup>

import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";

</script>

<template>
    <div data-theme="dark">
        <navbar></navbar>

        <div  class="hero min-h-screen place-items-end">
            <video src="../../img/production_id_4440816.mp4" type="video/mp4" class="object-cover w-full h-full max-h-screen" loop autoplay muted></video>
            <div class="hero-overlay bg-opacity-40 z-[1]"></div>
            <div class="hero-content text-neutral-content z-[1] min-w-full text-center py-20 lg:text-start lg:justify-start lg:p-20">
                <div class="max-w-2xl">
                    <h1 class="text-5xl font-bold">Audiovisuel</h1>
                    <p class="py-6">Nous vous souhaitons la bienvenue sur notre site web, nous espèrons que vous vous y touverez toutes les informations dont vous avez besoin. Toutefois, si vous avez des questions, n'hésitez pas à nous contacter ! C'est avec plaisir que nous vous répondrons.</p>
                </div>
            </div>
        </div>

        <div class="hero min-h-screen bg-base-200">
            <div class="hero-content flex-col md:flex-row justify-between max-w-7xl gap-10">
                <div class="text-center md:text-start">
                    <h1 class="text-4xl font-bold">Production audiovisuelle</h1>
                    <p class="py-6 text-sm">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                        exercitationem
                        quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
                    <button class="btn btn-neutral">S'informer</button>
                </div>
                <video src="../../img/pexels_videos_1534965.mp4" type="video/mp4" class="max-w-sm rounded-xl shadow-2xl" loop autoplay muted></video>
            </div>
        </div>

        <div class="hero min-h-screen bg-base-200">
            <div class="hero-content flex-col md:flex-row-reverse justify-between max-w-7xl gap-10">
                <div class="text-center md:text-start">
                    <h1 class="text-4xl font-bold">Événements</h1>
                    <p class="py-6 text-sm">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                        exercitationem
                        quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
                    <button class="btn btn-neutral">En savoir plus</button>
                </div>
                <img src="../../img/pexels-ricky-esquivel-1964474.jpg" class="max-w-sm rounded-xl shadow-2xl" />
            </div>
        </div>

        <div class="hero min-h-screen bg-base-200">
            <div class="hero-content flex-col md:flex-row justify-between max-w-7xl gap-10">
                <div class="text-center md:text-start">
                    <h1 class="text-4xl font-bold">Galerie photos</h1>
                    <p class="py-6 text-sm">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                        exercitationem
                        quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
                    <button class="btn btn-neutral">Découvrir</button>
                </div>
                <img src="../../img/pexels-timea-kadar-2215609.jpg" class="max-w-sm rounded-xl shadow-2xl" />
            </div>
        </div>




        <footer-page></footer-page>
    </div>
</template>



<script>

</script>

<style scoped>

</style>
