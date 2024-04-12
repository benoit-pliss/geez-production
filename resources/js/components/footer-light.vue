<template>
    <footer class="bg-white" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
      <div class="xl:grid xl:grid-cols-3 xl:gap-8">
        <img class="h-32" src="../../img/logo/logo-geez-dark.png" alt="Geez Production" />
        <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
          <div class="md:grid md:grid-cols-2 md:gap-8">
            <div>
              <h3 class="text-sm font-semibold leading-6 text-black">Geez Production</h3>
              <ul role="list" class="mt-6 space-y-4">
                <li v-for="item in navigation.services" :key="item.name">
                  <a :href="item.href" class="text-sm leading-6 text-neutral-700 hover:text-neutral-900">{{ item.name }}</a>
                </li>
              </ul>
            </div>
            <div class="mt-10 md:mt-0">
              <h3 class="text-sm font-semibold leading-6 text-black">Partenariats</h3>
              <ul role="list" class="mt-6 space-y-4">
                <li v-for="item in navigation.partenariats" :key="item.name">
                  <a :href="item.href" class="text-sm leading-6 text-neutral-700 hover:text-neutral-900 transition-all duration-100">{{ item.name }}</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="md:grid md:grid-cols-2 md:gap-8">
            <div>
              <h3 class="text-sm font-semibold leading-6 text-black">Editeurs</h3>
              <ul role="list" class="mt-6 space-y-4">
                <li v-for="item in navigation.editeurs" :key="item.name">
                  <a :href="item.href" class="text-sm leading-6 text-neutral-700 hover:text-neutral-900 transition-all duration-100">{{ item.name }}</a>
                </li>
              </ul>
            </div>
            <div class="mt-10 md:mt-0">
              <h3 class="text-sm font-semibold leading-6 text-black">Juridique</h3>
              <ul role="list" class="mt-6 space-y-4">
                <li v-for="item in navigation.legal" :key="item.name">
                  <a :href="item.href" class="text-sm leading-6 text-neutral-700 hover:text-neutral-900 transition-all duration-100">{{ item.name }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24 lg:flex lg:items-center lg:justify-between">
        <div>
          <h3 class="text-sm font-semibold leading-6 text-neutral-900">Inscrivez-vous à notre newsletter</h3>
          <p class="mt-2 text-sm leading-6 text-neutral-600">Les dernières nouvelles, toutes fraîches, livrées directement dans votre boîte de réception. </p>
        </div>
        <div class="mt-6 sm:flex sm:max-w-md lg:mt-0">
          <label for="email-address" class="sr-only">Adresse email</label>
          <input v-model="newsletterAddress" type="email" name="email-address" id="email-address" autocomplete="email" required="" class="w-full min-w-0 appearance-none rounded-md border-0 bg-white/5 px-3 py-1.5 text-base text-neutral-900 shadow-sm ring-1 ring-inset ring-black/20 placeholder:text-neutral-600 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:w-56 sm:text-sm sm:leading-6 outline-none"
          placeholder="Entrez votre adresse email">
          <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
            <button @click="subscribe" class="flex w-full items-center justify-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">S'inscrire</button>
          </div>
        </div>
      </div>
      <div class="mt-8 border-t border-white/10 pt-8 md:flex md:items-center md:justify-between">
        <div class="flex space-x-6 md:order-2">
          <a v-for="item in navigation.social" :key="item.name" :href="item.href" class="text-gray-500 hover:text-gray-400">
            <span class="sr-only">{{ item.name }}</span>
            <span v-html="item.icon" class="text-2xl"></span>
          </a>
        </div>
        <div class="flex flex-row items-center justify-center md:order-1 md:mt-0 space-x-6">
          <p class="mt-8 text-xs leading-5 text-neutral-600 md:order-1 md:mt-0">&copy; 2023 Geez Production - Tous droits réservés</p>
          <a class="mt-8 text-xs leading-5 text-neutral-600 md:order-1 md:mt-0" href="/admin/login">Espace admin</a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import {defineComponent, h, ref} from 'vue'
import { subscribeToNewsletter } from "../services/newsletterService.js";
import notificationService from "../services/notificationService.js";

const navigation = {
  services: [
    { name: 'Photos', href: '/photo' },
    { name: 'Vidéos', href: '/video' },
    { name: 'Contact', href: '/contact' },
  ],
  geez: [
    { name: 'À propos', href: '#' },
    { name: 'Contact', href: '#' },
    { name: 'Carrière', href: '#' },
    { name: 'Blog', href: '#' },
  ],
  partenariats: [
    { name: 'NAZA ESPORT', href: '' },
    { name: 'EWA', href: 'https://ewaproductions.fr' },
    { name: 'MAIN DREAM', href: '' },
  ],
  editeurs: [
    { name: 'Ragee MOUDAWI', href: '/home' },
    { name: 'Benoit PLISSONNIER', href: 'https://benoitplissonnier.fr' },
    { name: 'Victor FOUQUET', href: 'https://victorfouquet.com' },
  ],
  legal: [
    { name: 'Conditions d\'utilisation', href: '/legal' },
    { name: 'Politique de confidentialité', href: '/legal' },
    { name: 'Mentions légales', href: '/legal' },
    { name: 'Politique de cookies', href: '/legal' },
  ],
  social: [
    {
      name: 'Instagram',
      href: 'https://instagram.com/gee.z_prod?igshid=OGQ5ZDc2ODk2ZA==',
      icon: '<i class="fa-brands fa-instagram"></i>'
    },
    {
      name: 'YouTube',
      href: '#',
      icon: '<i class="fa-brands fa-youtube"></i>'
    },
    {
        name: 'TikTok',
        href: 'https://www.tiktok.com/@gee.z_prod?_t=8fxkxEsPeC0&_r=1',
        icon: '<i class="fa-brands fa-tiktok"></i>'
    }
  ],
}

const newsletterAddress = ref('');

const subscribe = () => {
    subscribeToNewsletter(newsletterAddress.value)
        .then((res) => {
            notificationService.addToast(res.data.message, 'success');
        })
        .catch((err) => {
            notificationService.addToast(err.response.data.message, 'error');
        });

}
</script>

