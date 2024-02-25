
<template>
    <div data-theme="light">
        <navbar></navbar>
        <div class="overflow-hidden bg-white py-32">
    <div class="mx-auto max-w-7xl px-6 lg:flex lg:px-8">
      <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-12 gap-y-16 lg:mx-0 lg:min-w-full lg:max-w-none lg:flex-none lg:gap-y-8">
        <div class="lg:col-end-1 lg:w-full lg:max-w-lg lg:pb-8">
          <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Photographie</h2>
          <p class="mt-6 text-xl leading-8 text-gray-600">Quasi est quaerat. Sit molestiae et. Provident ad dolorem occaecati eos iste. Soluta rerum quidem minus ut molestiae velit error quod. Excepturi quidem expedita molestias quas.</p>
          <p class="mt-6 text-base leading-7 text-gray-600">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat. Quasi aperiam sit non sit neque reprehenderit.</p>
          <div class="mt-10 flex">
            <button class="animate-bounce w-12 h-12 bg-gray-900 rounded-full flex items-center justify-center mx-3 text-white"
              id="scroll-down-gallery-button">
              <i class="fas fa-arrow-down "></i>
            </button>
          </div>
        </div>
        <div class="flex flex-wrap items-start justify-end gap-6 sm:gap-8 lg:contents">
          <div class="w-0 flex-auto lg:ml-auto lg:w-auto lg:flex-none lg:self-end">
            <img src="/storage/images/DSC09363.jpg" alt="" class="aspect-[7/5] w-[37rem] max-w-none rounded-2xl bg-gray-50 object-cover" />
          </div>
          <div class="contents lg:col-span-2 lg:col-end-2 lg:ml-auto lg:flex lg:w-[37rem] lg:items-start lg:justify-end lg:gap-x-8">
            <div class="order-first flex w-64 flex-none justify-end self-end lg:w-auto">
              <img src="/storage/images/B4EADABF-5904-414F-9E02-40E69F5A5963_1_105_c.jpeg" alt="" class="aspect-[4/3] w-[24rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover" />
            </div>
            <div class="flex w-96 flex-auto justify-end lg:w-auto lg:flex-none">
              <img src="/storage/images/DSC00832.jpg" alt="" class="aspect-[7/5] w-[37rem] max-w-none flex-none rounded-2xl bg-gray-50 object-cover" />
            </div>
            <div class="hidden sm:block sm:w-0 sm:flex-auto lg:w-auto lg:flex-none">
              <img src="/storage/images/DSC01026.jpg" alt="" class="aspect-[4/3] w-[24rem] max-w-none rounded-2xl bg-gray-50 object-cover" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <galerie></galerie>



        <footer-page></footer-page>
    </div>
</template>

<script>
import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";
import Galerie from "../components/galerie.vue";
export default {
    components: {
        Navbar,
        FooterPage,
        Galerie
    },
    mounted() {
        document.getElementById('scroll-down-gallery-button').addEventListener('click', () => {
            // Scroll à la galerie scroll lentement
            document.getElementById('gallery').scrollIntoView({ behavior: 'smooth' });
        });

    }
};
</script>

<style scoped>

</style>
