
<template>
    <header class="bg-slate-950 sticky top-0 transition-all duration-200 z-40">
      <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-2 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <a href="/home" class="-m-1.5 p-1.5 outline-none focus:outline-none">
            <span class="sr-only">Geez Production</span>
            <img class="h-14 w-auto" src="../../../public/logo-geez.png" alt="Logo Geez Production" />
          </a>
        </div>
        <div class="flex lg:hidden">
          <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400" @click="mobileMenuOpen = true">
            <span class="sr-only">Ouvrir le menu</span>
            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <a v-for="item in navigation" :key="item.name" :href="item.href" class="text-sm font-semibold leading-6 hover:bg-slate-900 transition-all duration-200 py-2 px-4 rounded-lg text-white cursor-pointer select-none">{{ item.name }}</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <!-- <a href="#" class="text-sm font-semibold leading-6 text-white">Se connecter <span aria-hidden="true">&rarr;</span></a> -->
        </div>
      </nav>
      <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
        <div class="fixed inset-0 z-50"/>
        <DialogPanel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-slate-950 px-6 py-2 sm:max-w-sm sm:ring-1 sm:ring-white/10">
          <div class="flex items-center justify-between">
            <a href="/home" class="-m-1.5 p-1.5 outline-none focus:outline-none">
              <span class="sr-only">Geez Production</span>
              <img class="h-14 w-auto" src="../../../public/logo-geez.png" alt="Logo Geez Production" />
            </a>
            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400" @click="mobileMenuOpen = false">
              <span class="sr-only">Fermer le menu</span>
              <XMarkIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-12 flow-root">
            <div class="-my-6 divide-y divide-gray-500/25">
              <div class="space-y-2 py-6">
                <a v-for="item in navigation" :key="item.name" :href="item.href" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-gray-800">{{ item.name }}</a>
              </div>
              <div class="py-6">
                <!-- <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-white hover:bg-gray-800">Se connecter</a> -->
              </div>
            </div>
          </div>
        </DialogPanel>
      </Dialog>
    </header>
  </template>

  <script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

  const navigation = [
    { name: 'Home', href: '/home' },
    { name: 'Photographie', href: '/photo' },
    { name: 'Audiovisuel', href: '/video' },
    { name: 'Contact', href: '/contact' },
  ]

  const mobileMenuOpen = ref(false)
  </script>
