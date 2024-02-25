<script setup>
import { ref } from 'vue'
import { CheckIcon, QuestionMarkCircleIcon, StarIcon } from '@heroicons/vue/20/solid'
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { ShieldCheckIcon } from '@heroicons/vue/24/outline'
import {Photos} from "../../Models/Photos.js";

const props = defineProps({
    photo: {
        type: Photos,
        required: true,
    },
})


const photo = {
    name: 'Image1',
    description:
        "Don't compromise on snack-carrying capacity with this lightweight and spacious bag. The drawstring top keeps all your favorite chips, crisps, fries, biscuits, crackers, and cookies secure.",
    url: 'http://localhost:8000/storage/images/annie-spratt-STLEtlSj1i4-unsplash.jpg',
}
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
            <!-- photo details -->
            <div class="lg:max-w-lg lg:self-end">


                <div class="mt-4">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ photo.name }}</h1>
                </div>

                <section aria-labelledby="information-heading" class="mt-4">
                    <h2 id="information-heading" class="sr-only">photo information</h2>

                    <div class="mt-4 space-y-6">
                        <p class="text-base text-gray-500">{{ photo.description }}</p>
                    </div>
                </section>
            </div>

            <!-- photo image -->
            <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
                <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg">
                    <img :src="photo.url" :alt="photo.name" class="h-full w-full object-cover object-center" />
                </div>
            </div>

            <!-- form pour modifier les informations de la photos -->



        </div>
    </div>
</template>

<style scoped>

</style>
