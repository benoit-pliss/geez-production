<template>
    <div data-theme="dark">
        <Navbar></Navbar>

        <div class="relative isolate bg-slate-950/80 min-h-screen">
            <div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">
                <div class="relative px-6 pb-20 pt-24 sm:pt-32 lg:static lg:px-8 lg:py-48">
                    <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
                        <div class="absolute inset-y-0 left-0 -z-10 w-full overflow-hidden ring-1 ring-white/5 lg:w-1/2">
                            <svg class="absolute inset-0 h-full w-full stroke-gray-700 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
                                aria-hidden="true">
                                <defs>
                                    <pattern id="54f88622-e7f8-4f1d-aaf9-c2f5e46dd1f2" width="200" height="200" x="100%"
                                        y="-1" patternUnits="userSpaceOnUse">
                                        <path d="M130 200V.5M.5 .5H200" fill="none" />
                                    </pattern>
                                </defs>
                                <svg x="100%" y="-1" class="overflow-visible fill-gray-800/20">
                                    <path d="M-470.5 0h201v201h-201Z" stroke-width="0" />
                                </svg>
                                <rect width="100%" height="100%" stroke-width="0"
                                    fill="url(#54f88622-e7f8-4f1d-aaf9-c2f5e46dd1f2)" />
                            </svg>
                            <div class="absolute -left-56 top-[calc(100%-13rem)] transform-gpu blur-3xl lg:left-[max(-14rem,calc(100%-59rem))] lg:top-[calc(50%-7rem)]"
                                aria-hidden="true">
                                <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-br from-[#80caff] to-[#4f46e5] opacity-20"
                                    style="clip-path: polygon(74.1% 56.1%, 100% 38.6%, 97.5% 73.3%, 85.5% 100%, 80.7% 98.2%, 72.5% 67.7%, 60.2% 37.8%, 52.4% 32.2%, 47.5% 41.9%, 45.2% 65.8%, 27.5% 23.5%, 0.1% 35.4%, 17.9% 0.1%, 27.6% 23.5%, 76.1% 2.6%, 74.1% 56.1%)" />
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold tracking-tight text-white">Parlons un peu de vos projets</h2>
                        <p class="mt-6 text-lg leading-8 text-gray-300">Intéressé par nos services ? N'hésitez pas à nous
                            contacter, nous serons ravis de vous répondre et de decouvrir votre projet.</p>
                        <dl class="mt-10 space-y-4 text-base leading-7 text-gray-300">
                            <div class="flex gap-x-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Telephone</span>
                                    <PhoneIcon class="h-7 w-6 text-gray-400" aria-hidden="true" />
                                </dt>
                                <dd><a class="hover:text-white" href="tel:+33 6 12 34 56 78">+33 6 58 18 45 10</a></dd>
                            </div>
                            <div class="flex gap-x-4">
                                <dt class="flex-none">
                                    <span class="sr-only">Email</span>
                                    <EnvelopeIcon class="h-7 w-6 text-gray-400" aria-hidden="true" />
                                </dt>
                                <dd><a class="hover:text-white" href="mailto:contact@geez-production.com">contact@geez-production.com</a></dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-48">
                    <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                            <div>
                                <label for="first-name" class="block text-sm font-semibold leading-6 text-white">Prénom</label>
                                <div class="mt-2.5">
                                    <input type="text" name="firstname" id="firstname" autocomplete="given-name" v-model="firstname"
                                        class="block w-full rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-semibold leading-6 text-white">Nom</label>
                                <div class="mt-2.5">
                                    <input type="text" name="lastname" id="lastname" autocomplete="family-name" v-model="lastname"
                                        class="block w-full rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-semibold leading-6 text-white">Adresse
                                    email</label>
                                <div class="mt-2.5">
                                    <input type="email" name="email" id="email" autocomplete="email" v-model="email"
                                        class="block w-full rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="phone-number" class="block text-sm font-semibold leading-6 text-white">Numéro
                                    de téléphone</label>
                                <div class="mt-2.5">
                                    <input type="tel" name="phone" id="phone" autocomplete="tel" v-model="phone"
                                        class="block w-full rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message"
                                    class="block text-sm font-semibold leading-6 text-white">Message</label>
                                <div class="mt-2.5">
                                    <textarea name="message" id="message" rows="4" v-model="message"
                                        class="block w-full rounded-md border-0 bg-white/5 px-3.5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit" @click="submit"
                                class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Envoyer le message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>

<script setup>
import Navbar from "@/components/NavbarGlobal.vue";
import Footer from "@/components/FooterDark.vue";
import { BuildingOffice2Icon, EnvelopeIcon, PhoneIcon } from '@heroicons/vue/24/outline'
import { postMessage } from "@/services/messagesService.js";
import notificationService from "@/services/notificationService.js";
import {ref} from 'vue'

const formdata = ref({
    firstname: '',
    lastname: '',
    email: '',
    phone: '',
    message: ''
});

const submit = () => {
    postMessage(
        firstname.value,
        lastname.value,
        email.value,
        phone.value,
        message.value
        )
    .then((res) => {
        notificationService.addToast(res.data.message, 'success');
        // Clear the form
        firstname.value = '';
        lastname.value = '';
        email.value = '';
        phone.value = '';
        message.value = '';
    })
    .catch((err) => {
        notificationService.addToast(err.response.data.message, 'error');
    });
};
</script>