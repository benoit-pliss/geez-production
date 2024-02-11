<script setup>
import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";

</script>

<template>
    <div data-theme="dark">
        <navbar></navbar>
        <div class="hero min-h-screen header-image">
            <div class="hero-overlay bg-opacity-60"></div>
            <div class="relative mx-auto flex max-w-3xl flex-col items-center px-6 py-32 text-center sm:py-64 lg:px-0">
                <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl">New arrivals are here</h1>
                <p class="mt-4 text-xl text-white">The new arrivals have, well, newly arrived. Check out the latest options
                    from
                    our summer small-batch release while they're still in stock.</p>
                <a href="#"
                    class="mt-8 inline-block rounded-md border border-transparent bg-white px-8 py-3 text-base font-medium text-gray-900 hover:bg-gray-100">Shop
                    New Arrivals</a>
            </div>
        </div>
  <div class="bg-gray-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <h2 class="text-center text-lg font-semibold leading-8 text-white">Nous traivaillons avec les grands et les petits</h2>
      <div class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/transistor-logo-white.svg" alt="Transistor" width="158" height="48" />
        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/reform-logo-white.svg" alt="Reform" width="158" height="48" />
        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/tuple-logo-white.svg" alt="Tuple" width="158" height="48" />
        <img class="col-span-2 max-h-12 w-full object-contain sm:col-start-2 lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/savvycal-logo-white.svg" alt="SavvyCal" width="158" height="48" />
        <img class="col-span-2 col-start-2 max-h-12 w-full object-contain sm:col-start-auto lg:col-span-1" src="https://tailwindui.com/img/logos/158x48/statamic-logo-white.svg" alt="Statamic" width="158" height="48" />
      </div>
    </div>
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
    }
};
</script>

<style scoped>.header-image {
    background-image: url('../../img/pexels-aleksandar-pasaric-1820770.jpg');
}</style>