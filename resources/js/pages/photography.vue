<script setup>
import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";

</script>

<template>
    <div data-theme="light">
        <navbar></navbar>

        <div class="hero min-h-screen place-items-end">
            <img src="../../img/pexels-redrec-2743739.jpg" class="object-cover w-full h-full max-h-screen" />
            <div class="hero-overlay bg-opacity-60 z-[1]"></div>
            <div class="hero-content text-neutral-content z-[1] min-w-full text-center py-20 lg:text-start lg:justify-start lg:p-20">
                <div class="max-w-2xl">
                    <h1 class="text-5xl font-bold">Photographie</h1>
                    <p class="py-6">Nous vous souhaitons la bienvenue sur notre site web, nous espèrons que vous vous y touverez toutes les informations dont vous avez besoin. Toutefois, si vous avez des questions, n'hésitez pas à nous contacter ! C'est avec plaisir que nous vous répondrons.</p>
                </div>
            </div>
        </div>



        <div class="hero bg-base-200 py-10">
            <div class="hero-content flex-col md:flex-row justify-between max-w-7xl gap-10">
                <div class="text-center md:text-start">
                    <h1 class="text-4xl font-bold">Séances photos</h1>
                    <p class="py-6 text-sm">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                        exercitationem
                        quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
                    <button class="btn btn-neutral">S'informer</button>
                </div>
                <img src="../../img/pexels-josh-hild-4424567.jpg" class="max-w-sm rounded-xl shadow-2xl" />
            </div>
        </div>

        <div class="hero bg-base-200 py-10">
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

        <!--<div class="carousel carousel-center max-w-md p-4 space-x-4 bg-neutral rounded-box">
            <div class="carousel-item">
                <img src="../../img/carousel/pexels-alice-marie-18886987.jpg" class="rounded-box object-cover" />
            </div>
            <div class="carousel-item">
                <img src="../../img/carousel/pexels-beladiya-nikunj-18862463.jpg" class="rounded-box object-cover" />
            </div>
            <div class="carousel-item">
                <img src="../../img/carousel/pexels-kelcey-shotit-18766323.jpg" class="rounded-box object-cover" />
            </div>
            <div class="carousel-item">
                <video src="../../img/carousel/pexels-audio-borough-18681432.mp4" type="video/mp4" class="rounded-box object-cover" loop autoplay muted></video>
            </div>
            <div class="carousel-item">
                <img src="../../img/carousel/pexels-kyle-miller-13909946.jpg" class="rounded-box object-cover" />
            </div>
            <div class="carousel-item">
                <img src="../../img/carousel/pexels-maheshwaran-shanmugam-18929375.jpg" class="rounded-box object-cover" />
            </div>
            <div class="carousel-item">
                <img src="../../img/carousel/pexels-nati-16776919.jpg" class="rounded-box object-cover" />
            </div>
        </div>-->

        <div class="hero bg-base-200 py-10">
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

<style scoped>

</style>
