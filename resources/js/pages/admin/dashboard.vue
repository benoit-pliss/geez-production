<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue'
import { ArrowRightIcon, Bars3Icon, BellIcon, XMarkIcon, LockClosedIcon, WindowIcon } from '@heroicons/vue/24/outline'
import DashboardPhotos from "../../components/adminComponents/dashboard-photos.vue";
import {isTokenValid, logout} from "../../services/authService.js";
import {ref} from "vue";
import ListeTags from "../../components/adminComponents/tags/liste-tags.vue";
import ListeMessage from "../../components/adminComponents/messages/liste-messages.vue";
import DashboardVideos from "../../components/adminComponents/dashboard-videos.vue";
import DashboardHome from "../../components/adminComponents/dashboard-home.vue";

const user = {
    name: 'Tom Cook',
    email: 'tom@example.com',
    imageUrl:
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
}

const selectedNavigation = ref('Dashboard');

const navigation = [
    { name: 'Dashboard'},
    { name: 'Photos'},
    { name: 'Vidéos'},
    { name: 'Tags'},
    { name: 'Messages'},
]


isTokenValid().then(response => {
    if (!response) {
        logout();
    }
});

const changePage = (e) => {
    selectedNavigation.value = e.name;
};

const deconnection = () => {
    logout();
    window.location.href = '#';
};




</script>

<template>
    <div class="min-h-full">
        <div class="bg-gray-800 pb-32">
            <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="border-b border-gray-700">
                        <div class="flex h-16 items-center justify-between px-4 sm:px-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-10" src="../../../img/logo/logo-geez.png" alt="Your Company" />
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-10 flex items-baseline space-x-4">
                                        <a v-for="item in navigation" :key="item.name" @click="changePage(item)" :class="[item.name === selectedNavigation ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
                                            {{ item.name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-4 flex items-center md:ml-6">
                                    <a href="/" class="text-gray-400 hover:text-white hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                        <WindowIcon class="h-6 w-6" aria-hidden="true" />
                                    </a>
                                    <button @click="deconnection" type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="absolute -inset-1.5" />
                                        <span class="sr-only">View notifications</span>
                                        <LockClosedIcon class="h-6 w-6" aria-hidden="true" />
                                    </button>
                                </div>
                            </div>
                            <div class="-mr-2 flex md:hidden">
                                <!-- Mobile menu button -->
                                <DisclosureButton class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <span class="absolute -inset-0.5" />
                                    <span class="sr-only">Open main menu</span>
                                    <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                                    <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                                </DisclosureButton>
                            </div>
                        </div>
                    </div>
                </div>

                <DisclosurePanel class="border-b border-gray-700 md:hidden">
                    <div class="space-y-1 px-2 py-3 sm:px-3">
                        <DisclosureButton v-for="item in navigation" :key="item.name" as="a" @click="changePage(item)" :class="[item.name === selectedNavigation ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">
                            {{ item.name }}
                        </DisclosureButton>
                        <DisclosureButton href="/" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white w-full text-left">
                            Retour au site
                        </DisclosureButton>
                        <DisclosureButton @click="deconnection" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white w-full text-left">
                            Déconnexion
                        </DisclosureButton>
                    </div>
                </DisclosurePanel>
            </Disclosure>
            <header class="py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-white">Dashboard</h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">


                    <DashboardHome v-if="selectedNavigation === 'Dashboard'"/>
                    <DashboardPhotos v-if="selectedNavigation === 'Photos'"/>
                    <DashboardVideos v-else-if="selectedNavigation === 'Vidéos'"/>
                    <ListeTags v-else-if="selectedNavigation === 'Tags'" :is-dashboard="true"/>
                    <ListeMessage v-else-if="selectedNavigation === 'Messages'"/>

                </div>
            </div>
        </main>
    </div>
</template>


