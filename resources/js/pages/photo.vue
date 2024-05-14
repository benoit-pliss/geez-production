<template>
  <div data-theme="light">
    <Navbar @replaceTag="replaceTag"></Navbar>
    <div class="overflow-hidden bg-white pt-12" v-if="pageTag === null">
      <div class="mx-auto max-w-7xl px-6 lg:flex lg:px-8">
        <div
          class="mx-auto grid max-w-2xl grid-cols-1 gap-x-12 gap-y-16 lg:mx-0 lg:min-w-full lg:max-w-none lg:flex-none lg:gap-y-8">
          <div class="lg:col-end-1 lg:w-full lg:max-w-lg lg:pb-8">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Photographie</h2>
            <p class="mt-6 text-xl leading-8 text-gray-600">Passionné par l’art de capturer des moments uniques, je suis
              votre photographe dévoué dans la création d’images exceptionnelles pour événement, entreprises, et
              portraits. Ma mission est de donner vie à vos idées à travers des clichés authentiques et mémorables.</p>
            <p class="mt-6 text-base leading-7 text-gray-600">Que ce soit pour sublimer votre entreprise, mettre en
              valeur vos événements ou immortaliser des moments précieux en portraits, je m’investis pleinement dans
              chaque projet. Avec une passion profonde pour la photographie, je m’engage à capturer l’essence de chaque
              sujet, en mettant en valeur sa beauté et son authenticité.</p>
            <div class="mt-10 flex">
              <button
                class="animate-bounce w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center mx-3 text-white"
                id="scroll-down-gallery-button">
                <i class="fas fa-arrow-down "></i>
              </button>
            </div>
          </div>
          <div class="flex flex-wrap items-start justify-end gap-6 sm:gap-8 lg:contents">
            <div class="w-0 flex-auto lg:ml-auto lg:w-auto lg:flex-none lg:self-end">
              <img src="../../img/acceuil/static/photo-4.jpeg" alt=""
                class="aspect-[7/5] w-[37rem] max-w-none rounded-2xl bg-gray-50 object-cover" />
            </div>
            <div
              class="contents lg:col-span-2 lg:col-end-2 lg:ml-auto lg:flex lg:w-[37rem] lg:items-start lg:justify-end lg:gap-x-8">
              <div class="order-first flex w-64 flex-none justify-end self-end lg:w-auto">
                <img src="../../img/acceuil/static/photo-1.jpeg" alt=""
                  class="aspect-[4/3] w-[24rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover" />
              </div>
              <div class="flex w-96 flex-auto justify-end lg:w-auto lg:flex-none">
                <img src="../../img/acceuil/static/photo-2.jpeg" alt=""
                  class="aspect-[7/5] w-[37rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover" />
              </div>
              <div class="hidden sm:block sm:w-0 sm:flex-auto lg:w-auto lg:flex-none">
                <img src="../../img/acceuil/static/photo-3.jpeg" alt=""
                  class="aspect-[4/3] w-[24rem] max-w-none rounded-2xl bg-gray-50 object-cover" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="px-4 md:px-8 lg:px-12">
        <div class="mt-16 text-center">
          <p class="mt-6 text-base leading-7 text-gray-600">En choisissant mes services, vous optez pour un photographe
            qui accorde une attention particulière à vos besoins. Je prends le temps nécessaire pour comprendre vos
            attentes et je m’engage à fournir un travail de qualité exceptionnelle. Votre satisfaction est ma priorité,
            et je m’efforcerai toujours de dépasser vos espérances.</p>
          <p class="mt-6 text-base leading-7 text-gray-600">Ensemble, créons des souvenirs visuels qui dureront toute
            une vie.</p>
          <p class="mt-6 text-base leading-7 text-gray-600 font-bold">Merci de faire confiance à GEEZ PRODUCTION
            Photographie !</p>
        </div>
      </div>
    </div>
    <galerie :pageTag="pageTag"></galerie>

    <Footer></Footer>
  </div>
</template>

<script setup>

import Navbar from "@/components/NavbarPhoto.vue";
import Footer from "@/components/FooterLight.vue";
import Galerie from "@/components/GaleriePhoto.vue";
import { onMounted, ref } from 'vue';

onMounted(() => {
  document.getElementById('scroll-down-gallery-button').addEventListener('click', () => {
    // Scroll à la galerie scroll lentement
    document.getElementById('gallery').scrollIntoView({ behavior: 'smooth' });
  });
});
const pageTag = ref(null);

const scrollDown = () => {
  document.getElementById('gallery').scrollIntoView({ behavior: 'smooth', block: 'start' });
};

const replaceTag = (tag) => {
    console.log(tag);
  pageTag.value = tag;
    scrollDown();
};
</script>

<style scoped></style>
