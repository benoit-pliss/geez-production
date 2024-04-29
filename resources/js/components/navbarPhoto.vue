
<template>
  <!-- quand on scroll, la navbar on met shadow -->
    <header class="bg-white sticky top-0 transition-all duration-200 z-40">
      <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-2 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <a href="/home" class="-m-1.5 p-1.5 outline-none focus:outline-none">
            <span class="sr-only">Geez Production</span>
            <img class="h-16 w-auto" src="../../img/logo/logo-geez-dark.png" alt="Logo Geez Production" />
          </a>
        </div>
        <div class="flex lg:hidden">
          <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-900" @click="mobileMenuOpen = true">
            <span class="sr-only">Ouvrir le menu</span>
            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <a v-for="item in navigation" :key="item.name" v-on:click="replaceTag(item.name)" class="text-sm font-semibold leading-6 hover:bg-gray-100 transition-all duration-200 py-2 px-4 rounded-lg text-gray-900 cursor-pointer select-none">{{ item.name }}</a>
          <Popover class="relative">
            <PopoverButton class="inline-flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 outline-none hover:bg-gray-100 py-2 px-4 rounded-lg transition-all duration-200">
              <span>Menu</span>
              <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
            </PopoverButton>

            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
              <PopoverPanel class="absolute right-0 z-10 mt-5 w-screen max-w-md px-4">
                <div class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5 m-2">
                  <div class="p-4">
                    <a v-for="item in solutions" :key="item.name" class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-gray-50 transition-all duration-200" :href="item.href">
                      <div class="mt-1 flex h-11 w-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white transition-all duration-200">
                        <component :is="item.icon" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600" aria-hidden="true" />
                      </div>
                      <div>
                        <p class="font-semibold text-gray-900 cursor-pointer">
                          {{ item.name }}
                        </p>
                        <p class="mt-1 text-gray-600 cursor-pointer">{{ item.description }}</p>
                      </div>
                    </a>
                  </div>
                </div>
              </PopoverPanel>
            </transition>
          </Popover>
        </div>
      </nav>
      <Dialog as="div" class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
        <div class="fixed inset-0 z-50"/>
        <DialogPanel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-2 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
          <div class="flex items-center justify-between">
            <a href="/home" class="-m-1.5 p-1.5 outline-none focus:outline-none">
              <span class="sr-only">Geez Production</span>
              <img class="h-16 w-auto" src="../../img/logo/logo-geez-dark.png" alt="Logo Geez Production" />
            </a>
            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-900" @click="mobileMenuOpen = false">
              <span class="sr-only">Fermer le menu</span>
              <XMarkIcon class="h-6 w-6" aria-hidden="true" />
            </button>
          </div>
          <div class="mt-12 flow-root">
            <div class="-my-6 divide-y divide-gray-500/25">
              <div class="space-y-2 py-6 cursor-pointer">
                <a v-for="item in navigation" :key="item.name" v-on:click="replaceTag(item.name)">
                  <span class="block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:text-indigo-600">{{ item.name }}</span>
                </a>
              </div>
              <div class="space-y-2 py-6">
                <a class="flex items-center justify-start space-x-1 text-gray-900 hover:text-indigo-600 cursor-pointer" v-for="item in solutions" :key="item.name" :href="item.href">
                  <component :is="item.icon" aria-hidden="true" class="h-6 w-6"/>
                  <span  class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7">{{ item.name }}</span>
                </a>
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

import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { ChevronDownIcon, PhoneIcon, PhotoIcon } from '@heroicons/vue/20/solid'
import {
  ArrowPathIcon,
  ChatBubbleBottomCenterTextIcon,
  CameraIcon,
  VideoCameraIcon,
  HomeIcon,
} from '@heroicons/vue/24/outline'

const solutions = [
  { 
    name: 'Accueil', 
    description: 'Ici, toujours plus de nouveautés !',
    href: '/home', icon: HomeIcon 
  },
  { 
    name: 'Photographie', 
    description: 'Parcourez nos plus beaux clichés',
    href: '/photo',
    icon: CameraIcon 
  },
  { 
    name: 'Audiovisuel', 
    description: 'Découvrez notre galerie de vidéos',
    href: '/video',
    icon: VideoCameraIcon 
  },
  { 
    name: 'Contact', 
    description: 'Une question ? Une réponse !',
    href: '/contact',
    icon: ChatBubbleBottomCenterTextIcon 
  },
]

const navigation = [
  { 
    name: 'Évenement', 
    onClick: () => replaceTag('Évenement')
  },
  { 
    name: 'Entreprise', 
    onClick: () => replaceTag('Entreprise')
  },
  { 
    name: 'Shooting', 
    onClick: () => replaceTag('Shooting')
  },
  { 
    name: 'Fêtes', 
    onClick: () => replaceTag('Fêtes')
  },
]

const emits = defineEmits(['replaceTag'])

const replaceTag = (tag) => {
  emits('replaceTag', tag)
  mobileMenuOpen.value = false
}


  const mobileMenuOpen = ref(false)
  </script>
